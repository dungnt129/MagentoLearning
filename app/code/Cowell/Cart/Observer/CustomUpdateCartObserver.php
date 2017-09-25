<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Cart\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomUpdateCartObserver implements ObserverInterface
{
    protected $request;
    /**
     * @var \Cowell\Cart\Helper\CustomChangeQtyProduct
     */
    protected $changeQtyProductHelper;

    /**
     * @param \Cowell\Cart\Helper\CustomChangeQtyProduct $changeQtyProductHelper
     */
    public function __construct(
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Cowell\Cart\Helper\CustomChangeQtyProduct $changeQtyProductHelper,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->changeQtyProductHelper = $changeQtyProductHelper;
        $this->stockConfiguration = $stockConfiguration;
        $this->request = $request;
        $this->qtyCounter = $qtyCounter;
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
        $moduleName = $this->request->getModuleName();
        $action     = $this->request->getActionName();
        if ($moduleName == 'checkout' && $action == 'updateItemOptions') {
            $items = $observer->getEvent()->getItem();
            $itemId = $observer->getEvent()->getRequest()->getParam('id');

            if ($items->getId() == $itemId) {
                $oldQtyParent = (int) $items->getOrigData()['qty'];
                $newQtyParent = (int) $items->getQty();

                if ($items->getHasChildren()) {
                    foreach ($items->getChildren() as $child) {
                        $oldQty = (int) $child->getOrigData()['qty'] * $oldQtyParent;
                        $newQty = (int) $child->getQty() * $newQtyParent;
                        $operator = '-';
                        $qty = $newQty - $oldQty;
                        if ($oldQty >= $newQty) {
                            $operator = '+';
                        }
                        $registeredItems[$child->getProductId()] = abs($qty);
                        $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, $operator);
                    }
                } else {
                    $operator = '-';
                    $qty = (int) $items->getOrigData()['qty'] - (int) $items->getQty();
                    if ((int) $items->getOrigData()['qty']  >= (int) $items->getQty()) {
                        $operator = '+';
                    }
                    $registeredItems[$items->getProductId()] = abs($qty);
                    $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, $operator);
                }
            }
        }

    }
}
