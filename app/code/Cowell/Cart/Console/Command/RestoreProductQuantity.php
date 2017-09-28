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

    protected $_quoteItemModel;

    protected $_quoteitemCollectionFactory;
    protected $_configCollectionFactory;

    protected  $_resource;

    /**
     * @param ModuleListInterface $moduleList
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Cowell\Cart\Model\QuoteItem $quoteItem,
        \Cowell\Cart\Model\ResourceModel\Item\CollectionFactory $quoteitemCollectionFactory,
        \Cowell\Cart\Model\ResourceModel\CoreConfig\CollectionFactory $configCollectionFactory,
        \Magento\Framework\App\ResourceConnection $resource

    )
    {
        $this->logger = $logger;
        $this->qtyCounter = $qtyCounter;
        $this->stockConfiguration = $stockConfiguration;
        $this->_quoteItemModel = $quoteItem;
        $this->_quoteitemCollectionFactory = $quoteitemCollectionFactory;
        $this->_configCollectionFactory = $configCollectionFactory;
        $this->_resource = $resource;
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
            $coreConfigCollection = $this->_configCollectionFactory->create();

            $data = $coreConfigCollection
                ->addFieldToFilter('path', ['eq' => 'persistent/options/lifetime'])
                ->getData();
            if ($data) {
                $this->expireTime = $data[0]['value'];
            }

            $now = time() - $this->expireTime;
            $now = date('Y-m-d h:i:s', $now);
            // Get data
            $dataQuoteItemAttribute = $this->_quoteItemModel->getAttributeQuoteItem($now);
            // Get connection
            $connection = $this->_resource->getConnection('Magento\Framework\App\ResourceConnection');
            $tableName = $connection->getTableName('quote_item');

            $parentQty = 0;
            if (!empty($dataQuoteItemAttribute)) {
                foreach ($dataQuoteItemAttribute as $quoteItem) {
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

                    $connection->update($tableName, ['cron_status' => self::CRON_STATUS_ACTIVE], ['item_id = ?' => $quoteItem['item_id']]);
                    $this->logger->info('Update status success: '. $quoteItem['item_id']);
                }

                $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, '+');
            } else {
                $this->logger->info('Quote item empty');
            }

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            $output->writeln('<error>Please disable maintenance mode after you resolved above issues</error>');
            return \Magento\Framework\Console\Cli::RETURN_FAILURE;
        }

    }


}