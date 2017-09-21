<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Cowell\Cart\Model;

use Magento\CatalogInventory\Api\Data\StockItemInterface;

/**
 * Class StockManagement
 */
class StockManagement extends \Magento\CatalogInventory\Model\StockManagement
{

    /**
     * Subtract product qtys from stock.
     * Return array of items that require full save
     *
     * @param string[] $items
     * @param int $websiteId
     * @return StockItemInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function registerProductsSale($items, $websiteId = null)
    {
        //if (!$websiteId) {
        $websiteId = $this->stockConfiguration->getDefaultScopeId();
        //}
        $this->getResource()->beginTransaction();
        $lockedItems = $this->getResource()->lockProductsStock(array_keys($items), $websiteId);
        $fullSaveItems = $registeredItems = [];
        foreach ($lockedItems as $lockedItemRecord) {
            $productId = $lockedItemRecord['product_id'];
            /** @var StockItemInterface $stockItem */
            $orderedQty = $items[$productId];
            $stockItem = $this->stockRegistryProvider->getStockItem($productId, $websiteId);
            $canSubtractQty = $stockItem->getItemId() && $this->canSubtractQty($stockItem);
            if (!$canSubtractQty || !$this->stockConfiguration->isQty($lockedItemRecord['type_id'])) {
                continue;
            }
            if (!$stockItem->hasAdminArea()
                && !$this->stockState->checkQty($productId, $orderedQty, $stockItem->getWebsiteId())
            ) {
                $this->getResource()->commit();
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Not all of your products are available in the requested quantity.')
                );
            }
            if ($this->canSubtractQty($stockItem)) {
                $stockItem->setQty($stockItem->getQty() - $orderedQty);
            }
            $registeredItems[$productId] = $orderedQty;
            if (!$this->stockState->verifyStock($productId, $stockItem->getWebsiteId())
                || $this->stockState->verifyNotification(
                    $productId,
                    $stockItem->getWebsiteId()
                )
            ) {
                $fullSaveItems[] = $stockItem;
            }
        }

        $this->getResource()->commit();
        return $fullSaveItems;
    }
}