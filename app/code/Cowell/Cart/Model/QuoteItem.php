<?php

namespace Cowell\Cart\Model;

class QuoteItem extends \Magento\Framework\Model\AbstractModel
{

    const ProductypeConfigurable = 'configurable';

    protected function _construct()
    {
        $this->_init('Cowell\Cart\Model\ResourceModel\Item');
    }

    /*
     * Get Old Qty
     * @return array
     *
     * Auth: H6iennv244
     * Created : 20-09-2017
     */
    public function getOldQty($itemId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $quoteItemCollection = $objectManager->create('\Cowell\Cart\Model\QuoteItem')->getCollection();
        $quoteItem = $quoteItemCollection
            ->addFieldToFilter('item_id', ['eq' => $itemId])
            ->getData();
        return $quoteItem;
    }

    /*
     * Get quote item
     * @return array
     *
     * Auth: Hiennv244
     * Created : 20-09-2017
     */
    public function getQuoteItem($itemId){
        $quoteItemParent = $this->getOldQty($itemId);
        if (!empty($quoteItemParent) && $quoteItemParent[0]['product_type'] == self::ProductypeConfigurable) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $quoteItemCollection = $objectManager->create('\Cowell\Cart\Model\QuoteItem')->getCollection();
            $quoteItem = $quoteItemCollection
                ->addFieldToFilter('parent_item_id', ['eq' => $quoteItemParent[0]['item_id']])
                ->getData();
            if (!empty($quoteItem)) {
                $quoteItem[0]['qty'] = $quoteItemParent[0]['qty'];
            }
            return $quoteItem;
        }

        return $quoteItemParent;
    }
}