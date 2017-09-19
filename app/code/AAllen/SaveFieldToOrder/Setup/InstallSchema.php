<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 6/8/2017
 * Time: 12:45 AM
 */

namespace AAllen\SaveFieldToOrder\Setup;


use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        // add the `custom_field` field
        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'custom_field',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => 'true',
                'comment' => 'A custom field for testing purposes'
            ]
        );
    }
}