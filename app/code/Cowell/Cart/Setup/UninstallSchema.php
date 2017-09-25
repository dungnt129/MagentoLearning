<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 9/25/17
 * Time: 9:47 AM
 */

namespace Cowell\Cart\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    /**
     * Module uninstall code
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $connection = $setup->getConnection();
        $connection->dropTable($connection->getTableName('your_table_name_here'));
        $setup->endSetup();
    }
}