<?php


namespace Cowll\Banner\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $connection = $setup->getConnection();
        $table = $setup->getTable('banners');
        if (!$connection->isTableExists($table)) {
            $table = $connection->newTable($table)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['primary' => true,'nullable' => false, 'identity' => true]
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false]
                )
                ->addColumn(
                    'link',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false]
                )->setOption("charset",'utf8');
            $connection->createTable($table);
        }

        $setup->endSetup();
    }
}
