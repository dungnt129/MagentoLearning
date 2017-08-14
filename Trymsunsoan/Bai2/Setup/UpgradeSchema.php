<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 8/14/2017
 * Time: 10:08 AM
 */

namespace Trymsunsoan\Bai2\Setup;
use Magento\Backend\Block\Widget\Tab;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Db\Ddl\Table;
class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();
        //Lay Ten cua Bang
        $tableName = $setup->getTable(  'banner');
//
//        if( version_compare( $context->getVersion(), '1.0.1' ) < 0 ){
//         dung check version cua table
//        }
        if (  version_compare( $context->getVersion(), '2.0.1' )){
            if( $connection->isTableExists( $tableName ) != true){
                $table = $connection->newTable( $tableName )->addColumn(
                    'id',
                    Table::TYPE_INTEGER ,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable'=>false, 'primary' => true]
                )->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    [ 'nullable'=>false, 'default' => '']
                )->addColumn(
                    'link',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable'=>false, 'default' => '']
                )->addColumn(
                    'sort_order',
                    Table::TYPE_SMALLINT,
                    255,
                    ['nullable'=>false, 'default' => 0]
                )->addColumn(
                    'status',
                    Table::TYPE_BOOLEAN,
                    null,
                    ['nullable'=>false, 'default' => false]
                )->setOption('charset', 'utf8');
                $connection->createTable( $table );
            }else{
                $setup->run( "ALTER TABLE ".$tableName. " ADD COLUMN sort_order SMALLINT, ADD COLUMN status BOOLEAN" );
            }
        }
        $setup->endSetup();
    }
}