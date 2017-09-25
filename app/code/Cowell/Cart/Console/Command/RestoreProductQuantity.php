<?php
namespace Cowell\Cart\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RestoreProductQuantity extends Command
{
    protected $logger;
    protected $expireTime = 0;
    protected $resource;

    const PRODUCT_TYPE_SIMPLE       = 'simple';
//    const PRODUCT_TYPE_CONFIGURABLE = 'configurable';
//    const PRODUCT_TYPE_BUNDLE       = 'bundle';
    const CRON_STATUS_ACTIVE = 1;

    /**
     * @param ModuleListInterface $moduleList
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration
    )
    {
        $this->logger = $logger;
        $this->qtyCounter = $qtyCounter;
        $this->stockConfiguration = $stockConfiguration;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('cowell:restore_product_qty');
        $this->setDescription('Restore product cart command');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
//            $date = (new \DateTime())->setTimestamp(time());
            $websiteId = $this->stockConfiguration->getDefaultScopeId();

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $coreConfigCollection = $objectManager->create('\Cowell\Cart\Model\CoreConfig')->getCollection();
            $data = $coreConfigCollection
                ->addFieldToFilter('path', ['eq' => 'persistent/options/lifetime'])
                ->getData();
            if ($data) {
                $this->expireTime = $data[0]['value'];
            }

            $now = time() - $this->expireTime;
            $now = date('Y-m-d h:i:s', $now);

            $collection = $objectManager->create('\Cowell\Cart\Model\QuoteItem')->getCollection();
            $collection
                ->getSelect()
                ->join(
                ['quote' => $collection->getTable('quote')],
                'main_table.quote_id = quote.entity_id',
                ['quote.entity_id'=>'quote.entity_id'])
                ->where("quote.is_active = 1")
                ->where("quote.items_count > 0")
                ->where("CASE quote.updated_at WHEN '0000-00-00 00:00:00' THEN quote.created_at <= '$now' ELSE quote.updated_at <= '$now' END")
                ->where("main_table.cron_status is null")
                ->where("main_table.item_id >= 57")
                ->order("main_table.parent_item_id"," asc")
                ->order("main_table.item_id"," asc");

//            echo $collection->getSelect();die;
            $attributes = $collection->getData();
            // Get connection
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $tableName = $resource->getTableName('quote_item');
            $parentQty = 0;
            foreach ($attributes as $quoteItem) {
                $parentQty = $quoteItem['qty'];
                if ($quoteItem['parent_item_id']) { // child
                    $qty = $parentQty * $quoteItem['qty'];
                    $registeredItems[$quoteItem['product_id']] = $qty;
                } else {
                    $qty = $parentQty;
                    if ($quoteItem['product_type'] == self::PRODUCT_TYPE_SIMPLE) {
                        $registeredItems[$quoteItem['product_id']] = $qty;
                    }
                }

                $sql = "UPDATE " . $tableName . " SET cron_status = 1 WHERE item_id = " . $quoteItem['item_id'];
                $connection->query($sql);
//                $connection->update($tableName, ['cron_status' => self::CRON_STATUS_ACTIVE], ['item_id = ?' => $quoteItem['item_id']]);
            }

            $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, '+');
            die();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            $output->writeln('<error>Please disable maintenance mode after you resolved above issues</error>');
            return \Magento\Framework\Console\Cli::RETURN_FAILURE;
        }

    }


}