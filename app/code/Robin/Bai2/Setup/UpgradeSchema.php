<?php
namespace Robin\Bai2\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->dropTable($setup->getTable('banner'));

        $conn = $setup->getConnection();

        $check_exiist = $conn->isTableExists("banner");

        if($check_exiist)
        {
            $sql = "ALTER TABLE `banner`
ADD COLUMN `sort_order`  tinyint NULL AFTER `link`,
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `sort_order`
";
            $setup->run($sql);
        }
        else
        {

            $table = $conn->newTable("banner");
            $table->addColumn("id",Table::TYPE_INTEGER,null,["primary" => true,"nullable" => false,"identity" => true]);
            $table->addColumn("image",Table::TYPE_TEXT,255,["nullable" => false]);
            $table->addColumn("link",Table::TYPE_TEXT,255,["nullable" => false]);
            $table->addColumn("sort_order",Table::TYPE_SMALLINT,null,["nullable" => false]);
            $table->addColumn("status",Table::TYPE_BOOLEAN,null,["default" => true]);
            $table->setOption("charset",'utf8');
            $conn->createTable($table);
        }

        $setup->endSetup();
    }
}