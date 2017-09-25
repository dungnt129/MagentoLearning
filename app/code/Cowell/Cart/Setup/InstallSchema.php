<?php
namespace Cowell\Cart\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $tableName = $setup->getTable('quote_item');

        //add new file table

        if ($connection->isTableExists($tableName) == true && $connection->tableColumnExists($tableName,'cron_status') == false){
            $setup->run("ALTER TABLE " . $tableName . " ADD COLUMN cron_status tinyint(1) AFTER base_weee_tax_row_disposition;");
        }

        $setup->endSetup();
    }
}