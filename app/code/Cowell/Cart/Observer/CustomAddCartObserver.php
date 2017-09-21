<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomAddCartObserver implements ObserverInterface
{
    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration
    ) {
        $this->qtyCounter = $qtyCounter;
        $this->stockConfiguration = $stockConfiguration;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * Auth: Hiennv6244
     * Created : 20-09-2017
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $websiteId = $this->stockConfiguration->getDefaultScopeId();
        $items = $observer->getEvent()->getItems();
        if (!empty($items)) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $model = $objectManager->create('Cowell\Cart\Model\QuoteItem');
            $itemId = $items[0]->getItemId();
            $quoteItem = $model->getQuoteItem($itemId);
            if (empty($quoteItem)) {
                if (count($items) == 1) {
                    $registeredItems[$items[0]->getProductId()] = $items[0]->getQty();
                } elseif (count($items) == 2) {
                    $registeredItems[$items[1]->getProductId()] = $items[0]->getQty();
                }
                $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, '-');
            }
        }
    }
}
