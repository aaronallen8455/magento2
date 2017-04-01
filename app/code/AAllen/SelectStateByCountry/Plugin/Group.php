<?php


namespace AAllen\SelectStateByCountry\Plugin;

use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Magento\Directory\Api\Data\CountryInformationInterface;
use Magento\Directory\Helper\Data;

class Group
{
    const DIRECTORY_REGION_REQUIRED_GROUP_ID = 'region';

    protected $directoryHelper;

    protected $countryInformationAcquirer;

    public function __construct(Data $directoryHelper, CountryInformationAcquirerInterface $countryInformationAcquirer)
    {
        $this->directoryHelper = $directoryHelper;
        $this->countryInformationAcquirer = $countryInformationAcquirer;
    }

    protected function getRegionsForCountry(CountryInformationInterface $countryInfo) : array
    {
        $options = [];

        $availableRegions = $countryInfo->getAvailableRegions() ?: [];

        foreach ($availableRegions as $region) {
            $options[$region->getCode()] = [
                'value' => $region->getCode(),
                'label' => $region->getName()
            ];
        }

        return $options;
    }

    protected function getDynamicConfigFields() : array
    {
        $countriesWithStatesRequired = $this->directoryHelper->getCountriesWithStatesRequired();

        $dynamicConfigFields = [];

        foreach ($countriesWithStatesRequired as $index => $country) {
            $configId = 'regions-allowed-' . $country;

            $countryInfo = $this->countryInformationAcquirer->getCountryInfo($country);
            $regionOptions = $this->getRegionsForCountry($countryInfo);

            $configType = !empty($regionOptions) ? 'multiselect' : 'text';

            $dynamicConfigFields[$configId] = !empty($regionOptions) ?
                [
                    'id' => $configId,
                    'type' => 'multiselect',
                    'sortOrder' => ($index * 10),
                    'showInDefault' => '1',
                    'showInWebsite' => '0',
                    'showInStore' => '0',
                    'label' => __('Allowed Regions: %1', $countryInfo->getFullNameEnglish()),
                    'options' => [
                        'option' => $this->getRegionsForCountry($countryInfo)
                    ],
                    'comment' => __('Select allowed regions for %1', $countryInfo->getFullNameEnglish()),
                    '_elementType' => 'field',
                    'path' => 'general/region'
                ] : [
                    'id' => $configId,
                    'type' => 'text',
                    'sortOrder' => ($index * 10),
                    'showInDefault' => '1',
                    'showInWebsite' => '0',
                    'showInStore' => '0',
                    'label' => __('Allowed Regions: %1', $countryInfo->getFullNameEnglish()),
                    'comment' => __('Select allowed regions for %1', $countryInfo->getFullNameEnglish()),
                    '_elementType' => 'field',
                    'path' => 'general/region'
                ];

        }

        return $dynamicConfigFields;
    }

    public function beforeSetData(
        \Magento\Config\Model\Config\Structure\Element\Group $subject,
        array $data, $scope
    ) {
        if ($data['id'] === self::DIRECTORY_REGION_REQUIRED_GROUP_ID) {
            $dynamicFields = $this->getDynamicConfigFields();

            if (!empty($dynamicFields)) {
                $data['children'] = array_merge($data['children'], $dynamicFields);
            }
            //$data['children']['testing'] = [
            //    'id' => 'this-is-my-field',
            //    'type' => 'multiselect',
            //    'sortOrder' => 50,
            //    'showInDefault' => '1',
            //    'label' => 'My Dynamic Field',
            //    'options' => [
            //        'option' => [
            //            'value1' => [
            //                'value' => 'value1',
            //                'label' => 'Label 1'
            //            ]
            //        ]
            //    ],
            //    '_elementType' => 'field'
            //];
        }

        return [$data, $scope];
    }
}
