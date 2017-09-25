<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\CatalogInventory\Model\ResourceModel\Stock as ResourceStock;

class CustomUpdateItemObserver implements ObserverInterface
{

    protected $request;
    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->qtyCounter = $qtyCounter;
        $this->stockConfiguration = $stockConfiguration;
        $this->request = $request;
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
        if ($this->request->getModuleName() == 'checkout') {
            $websiteId = $this->stockConfiguration->getDefaultScopeId();
            $info = $observer->getEvent()->getInfo()->toArray();

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $model = $objectManager->create('Cowell\Cart\Model\QuoteItem');
            if (count($info) > 0) {
                foreach ($info as $itemId => $itemInfo) {
                    $registeredItems= [];
                    //get old quote item
                    $quoteItemOld = $model->getOldQty($itemId);
                    //get list quote item with parent_id $itemId
                    $quoteItem = $model->getQuoteItem($itemId);
                    $operator = '-';
                    $qty = (int) $itemInfo['qty'] - (int) $quoteItemOld[0]['qty'];
                    $qty = abs($qty);
                    if ((int) $itemInfo['qty'] <= (int) $quoteItemOld[0]['qty']) {
                        $operator = '+';
                    }
                    if (count($quoteItem) > 0){
                        foreach ($quoteItem as $key => $value) {
                            $registeredItems[$value['product_id']] = (int) $value['qty'] * $qty;
                        }
                    } else {
                        $registeredItems[$quoteItemOld[0]['product_id']] = $qty;
                    }
                    $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, $operator);
                }
            }
        }
    }
}
