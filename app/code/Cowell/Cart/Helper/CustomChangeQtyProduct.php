<?php

namespace Cowell\Cart\Helper;


class CustomChangeQtyProduct extends \Magento\Framework\App\Helper\AbstractHelper
{

    const PRODUCT_TYPE_SIMPLE = 'simple';
    const PRODUCT_TYPE_CONFIGURABLE = 'configurable';
    const PRODUCT_TYPE_BUNDLE = 'bundle';
    const PRODUCT_TYPE_GROUPED = 'grouped';
    const PRODUCT_TYPE_DOWNLOADABLE= 'downloadable';


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
    public function updateQtyProduct($items, $action)
    {
        $websiteId = $this->stockConfiguration->getDefaultScopeId();
        if (!empty($items)) {
            $productType = $items[0]->getProductType();
            // case add item
            if ($action == 'updateItemOptions' && $productType == 'simple') {
                return false;
            }
            $registeredItems = $this->renderItems($items, $productType);
            $this->qtyCounter->correctItemsQty($registeredItems, $websiteId, '-');
        }
    }

    /**
     * @param array $items
     *
     * Auth: Hiennv6244
     * Created : 22-09-2017
     */

    public function renderItems($items, $productType) {
        $registeredItems = [];
        $qtyParent = 1;
        if ($productType !== self::PRODUCT_TYPE_SIMPLE && $productType !== self::PRODUCT_TYPE_GROUPED){
            $qtyParent = $items[0]->getQtyToAdd() ;
        }

        switch ($productType) {
            case self::PRODUCT_TYPE_GROUPED:
                foreach ($items as $key => $value) {
                    $registeredItems[$value->getProductId()] = $value->getQtyToAdd() * $qtyParent;
                }
                break;
            case self::PRODUCT_TYPE_DOWNLOADABLE:
                foreach ($items as $key => $value) {
                    $registeredItems[$value->getProductId()] = $value->getQtyToAdd() * $qtyParent;
                }
                break;
            default:
                foreach ($items as $key => $value) {
                    if ($value->getProductType() != 'simple') {
                        continue;
                    } else {
                        $registeredItems[$value->getProductId()] = $value->getQtyToAdd() * $qtyParent;
                    }
                }
                break;
        }
        return $registeredItems;
    }
}
