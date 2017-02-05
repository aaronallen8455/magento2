<?php


namespace AAllen\Images\Setup;

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

        $table_aallen_image = $setup->getConnection()->newTable($setup->getTable('aallen_image'));

        
        $table_aallen_image->addColumn(
            'image_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,),
            'Entity ID'
        );
        

        
        $table_aallen_image->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            50,
            ['nullable' => False],
            'Image Title'
        );
        

        
        $table_aallen_image->addColumn(
            'file_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            100,
            ['nullable' => False],
            'Image File Name'
        );
        

        
        $table_aallen_image->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['default' => 'TIMESTAMP_INIT','nullable' => False],
            'Image Creation Time'
        );
        

        
        $table_aallen_image->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['default' => 'TIMESTAMP_INIT_UPDATE','nullable' => False],
            'Image Modification Time'
        );
        

        
        $table_aallen_image->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['default' => '1','nullable' => False],
            'Is Image Active'
        );
        

        $setup->getConnection()->createTable($table_aallen_image);

        $setup->endSetup();
    }
}
