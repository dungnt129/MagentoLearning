<?php

namespace Cowell\Cart\Helper;


class CustomChangeQtyProduct extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @param \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter
     * @param \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration
     */
    public function __construct(
        \Magento\CatalogInventory\Model\ResourceModel\QtyCounterInterface $qtyCounter,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->qtyCounter = $qtyCounter;
        $this->stockConfiguration = $stockConfiguration;
        parent::__construct($context);
    }

    /**
     * @param array $items
     * @return bool
     *
     * Auth: Hiennv6244
     * Created : 21-09-2017
     */
    public function updateQtyProduct($items, $flagUpdate = false)
    {
        $websiteId = $this->stockConfiguration->getDefaultScopeId();
        if (!empty($items)) {
            if ($flagUpdate) {
                //case update item
                $operator = '-';
                $qty = (int) $items->getQtyToAdd() - (int) $items->getOrigData()['qty'];
                if ((int) $items->getOrigData()['qty'] >= (int) $items->getQtyToAdd()) {
                    $qty = (int)  $items->getOrigData()['qty'] - (int) $items->getQtyToAdd();
                    $operator = '+';
                }
                if ($items->getHasChildren()) {
                    foreach ($items->getChildren() as $child) {
                        $registeredItems[$child->getProductId()] = $qty;
                    }
                } else {
                    $registeredItems[$items->getProductId()] = $qty;
                }
               
                $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, $operator);

            } else {
                // case add item
                if ($items->getHasChildren()) {
                    foreach ($items->getChildren() as $child) {
                        $registeredItems[$child->getProductId()] = $items->getQtyToAdd();
                    }
                } else {
                    $registeredItems[$items->getProductId()] = $items->getQtyToAdd();
                }
                $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, '-');
            }
        }
    }

}
