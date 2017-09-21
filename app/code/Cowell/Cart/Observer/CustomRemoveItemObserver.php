<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Model\ResourceModel\Stock as ResourceStock;

class CustomRemoveItemObserver implements ObserverInterface
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
        $registeredItems = [];
        $items = $observer->getEvent()->getQuoteItem();
        if ($items) {
            if ($items->getHasChildren()) {
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $model = $objectManager->create('Cowell\Cart\Model\QuoteItem');
                foreach ($items->getChildren() as $child) {
                    $itemId = $child->getParentItemId();
                    $quoteItem = $model->getOldQty($itemId);
                    $registeredItems[$child->getProductId()] = $quoteItem[0]['qty'];
                }
            } else {
                $registeredItems[$items->getProductId()] = $items->getQty();
            }
        }
        $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, '+');
    }
}