<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 8/15/17
 * Time: 4:44 PM
 */

namespace Robin\Bai2\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;


class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface {

    public  function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // TODO: Implement install() method.
        $setup->startSetup();

        $connection = $setup->getConnection();

        $tableName = $setup->getTable("banner");

        if ($connection->isTableExists($tableName) !== true) {
            $table = $connection->newTable($tableName)->addColumn(
                "id",
                Table::TYPE_INTEGER,
                null,
                ["primary"=> true, "nullable" => false, "identity" => true]

            )->addColumn(
                "image",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false]

            )->addColumn(
                "link",
                Table::TYPE_TEXT,
                255,
                ["nullable" => false]

            )->setOption("charset", "utf8");

            $connection->createTable($table);

        }



        $setup->endSetup();

    }
}