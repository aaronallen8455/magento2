<?php

namespace AAllen\Faq\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create the table 'aallen_faq_faq'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('aallen_faq_faq')
        )->addColumn(
            'faq_id', Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'FAQ ID'
        )->addColumn(
            'question',
            Table::TYPE_TEXT,
            500,
            ['nullable'=>false, 'default'=>''],
            'Question'
        )->addColumn(
            'answer',
            Table::TYPE_TEXT,
            5000,
            ['nullable'=>false, 'default'=>''],
            'Answer'
        )->addColumn(
            'position',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default'=>'1'],
            'Position'
        )->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            null,
            ['nullable'=>false, 'default'=>'1'],
            'Is Question enabled?'
        )->addColumn(
            'creation_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable'=>false, 'default'=>Table::TIMESTAMP_INIT],
            'Creation Time'
        )->addColumn(
            'update_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable'=>false, 'default'=>Table::TIMESTAMP_INIT_UPDATE],
            'Update Time'
        )->setComment('AAllen Faq questions');

        $installer->getConnection()->createTable($table);

        /**
         * Create table 'aallen_faq_faq_store'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('aallen_faq_faq_store')
        )->addColumn(
            'faq_id',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Faq ID'
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addIndex(
            $installer->getIdxName('aallen_faq_faq_store', ['store_id']),
            ['store_id']
        )->addForeignKey(
            $installer->getFkName('aallen_faq_faq_store', 'faq_id', 'aallen_faq_faq', 'faq_id'),
            'faq_id',
            $installer->getTable('aallen_faq_faq'),
            'faq_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('aallen_faq_faq_store', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        )->setComment(
            'AAllen Faq To Store Linkage Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}