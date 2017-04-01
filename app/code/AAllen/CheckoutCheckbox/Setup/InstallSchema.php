<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/31/2017
 * Time: 6:47 PM
 */

namespace AAllen\CheckoutCheckbox\Setup;


use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // add the `is_giftwrapped` field
        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'is_giftwrapped',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                'nullable' => 'true',
                'comment' => 'Does this quote include gift wrapping'
            ]
        );
    }
}