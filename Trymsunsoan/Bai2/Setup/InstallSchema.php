<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 8/11/2017
 * Time: 5:04 PM
 */
namespace Trymsunsoan\Bai2\Setup;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $tableName = 'banner';
        $setup->startSetup();
//      tao connection
        $connection = $setup->getConnection();
//        ktra bảng đã tồn tại hay chưa
        if( $connection->isTableExists( $tableName ) != true ){;
//          tao connection
            $connection = $setup->getConnection();
//          Them cac column vao bang
            $table = $connection->newTable($tableName)->addColumn(
                "id",
                Table::TYPE_INTEGER,
                null,
                ["primary" => true, "nullable" => false, 'identity' => true ]
            )->addColumn(
                "image",
                Table::TYPE_TEXT,
                255,
                [ "nullable" => false]
            )->addColumn(
                "link",
                Table::TYPE_TEXT,
                255,
                [ "nullable" => false ]
            )->setOption('charset', 'utf8');
//        Create table
            $connection->createTable( $table );
        }

        $setup->endSetup();
    }
}