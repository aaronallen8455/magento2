<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/22/2016
 * Time: 4:03 AM
 */

namespace AAllen\CustomerAtt\Setup;



use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $customerSetupFactory;

    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $customerEntity = Customer::ENTITY;

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->removeAttribute(
            $customerEntity,
            'test_attribute'
        );

        $setup->endSetup();
    }

}