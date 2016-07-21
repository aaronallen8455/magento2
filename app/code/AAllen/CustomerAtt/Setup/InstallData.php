<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/18/2016
 * Time: 2:35 AM
 */

namespace AAllen\CustomerAtt\Setup;


use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $customerSetupFactory;

    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $customerEntity = Customer::ENTITY;

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        //$customerSetup->installEntities();

        $customerSetup->addAttribute(
            $customerEntity,
            'test_attribute',
            ['type' => 'varchar']
        );

        $setup->endSetup();
    }

}