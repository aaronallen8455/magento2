<?php

namespace AAllen\Showcase\Model\Rule\Condition;

use Magento\Rule\Model\Condition\Combine;
use Magento\Rule\Model\Condition\Context;

class Combine5 extends Combine
{
    /**
     * @var \Magento\CatalogWidget\Model\Rule\Condition\ProductFactory
     */
    protected $productFactory;

    /**
     * {@inheritdoc}
     */
    protected $elementName = 'parameters';

    /**
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, \Magento\CatalogWidget\Model\Rule\Condition\ProductFactory $conditionFactory, array $data = [])
    {
        parent::__construct($context, $data);

        $this->setType('AAllen\Showcase\Model\Rule\Condition\Combine5');

        $this->productFactory = $conditionFactory;
    }

    /**
     * @return string
     */
    public function asHtml()
    {
        $html = $this->getTypeElement()->getHtml() . __(
            'If %1 of these conditions are %2:',
            $this->getAggregatorElement()->getHtml(),
            $this->getValueElement()->getHtml()
        );
        if ($this->getId() != '5') {
            $html .= $this->getRemoveLinkHtml();
        }
        return $html;
    }

    /**
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $productAttributes = $this->productFactory->create()->loadAttributeOptions()->getAttributeOption();
        $attributes = [];
        foreach ($productAttributes as $code => $label) {
            $attributes[] = [
                'value' => 'Magento\CatalogWidget\Model\Rule\Condition\Product|' . $code,
                'label' => $label,
            ];
        }
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive(
            $conditions,
            [
                [
                    'value' => 'AAllen\Showcase\Model\Rule\Condition\Combine5',
                    'label' => __('Conditions Combination'),
                ],
                ['label' => __('Product Attribute'), 'value' => $attributes]
            ]
        );
        return $conditions;
    }

    /**
     * Collect validated attributes for Product Collection
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @return $this
     */
    public function collectValidatedAttributes($productCollection)
    {
        foreach ($this->getConditions() as $condition) {
            $condition->addToCollection($productCollection);
        }
        return $this;
    }
}
