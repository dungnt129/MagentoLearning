<?php


namespace Cowll\Banner\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup,ModuleContextInterface $context) {
        $setup->startSetup();
        //update script
        if (version_compare($context->getVersion(), "1.0.6", "<")) {
            $connection = $setup->getConnection();
            $table = $setup->getTable('banners');
            if ($connection->isTableExists($table)) {
            $connection
                ->addColumn(
                    $table,
                    'sort_order',
                    [
                        'type' => Table::TYPE_SMALLINT,
                        'nullable' =>true,
                        'comment' =>'sort order'
                    ]
                );
                $connection->addColumn(
                    $table,
                    'status',
                    [
                        'type' => Table::TYPE_BOOLEAN,
                        'default' => true,
                        'nullable' =>false,
                        'comment' => 'status'
                    ]
                );
            }else {
                $table = $connection->newTable($table)
                    ->addColumn(
                        'id',
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'primary' => true,
                            'nullable' => false,
                            'identity' => true
                        ]
                    )
                    ->addColumn(
                        'image',
                        Table::TYPE_TEXT,
                        255,
                        [
                            'nullable' => false
                        ]
                    )
                    ->addColumn(
                        'link',
                        Table::TYPE_TEXT,
                        255,
                        [
                            'nullable' => false
                        ]
                    )
                    ->setOption("charset",'utf8');
                $connection->createTable($table);
            }
        }
        //end update script
        $setup->endSetup();
    }
}
