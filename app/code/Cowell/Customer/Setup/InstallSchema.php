<?php
namespace Cowell\Customer\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $tableName = $setup->getTable('customer_entity');

        //add new file table

        if ($connection->isTableExists($tableName) == true){
            $setup->run("ALTER TABLE " . $tableName . " ADD COLUMN nmid VARCHAR(100) AFTER password_hash;");
        }

        $setup->endSetup();
    }
}