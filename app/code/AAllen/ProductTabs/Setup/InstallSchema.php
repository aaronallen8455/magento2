<?php


namespace AAllen\ProductTabs\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table_aallen_producttabs_tab = $setup->getConnection()->newTable($setup->getTable('aallen_producttabs_tab'));

        
        $table_aallen_producttabs_tab->addColumn(
            'tab_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,),
            'Entity ID'
        );
        

        
        $table_aallen_producttabs_tab->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['default' => '1','unsigned' => true],
            'Order of tabs'
        );
        

        
        $table_aallen_producttabs_tab->addColumn(
            'label',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            50,
            ['nullable' => False],
            'Title for tab'
        );
        

        
        $table_aallen_producttabs_tab->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'Html content'
        );
        

        $setup->getConnection()->createTable($table_aallen_producttabs_tab);

        $setup->endSetup();
    }
}
