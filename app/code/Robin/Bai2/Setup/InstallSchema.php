<?php
namespace Robin\Bai2\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
//        $setup->startSetup();
//        $conn = $setup->getConnection();
//        $table = $conn->newTable("banner");
//        $table->addColumn("id",Table::TYPE_INTEGER,null,["primary" => true,"nullable" => false,"identity" => true]);
//        $table->addColumn("image",Table::TYPE_TEXT,255,["nullable" => false]);
//        $table->addColumn("link",Table::TYPE_TEXT,255,["nullable" => false]);
//        $table->setOption("charset",'utf8');
//        $conn->createTable($table);
//        $setup->endSetup();
    }
}