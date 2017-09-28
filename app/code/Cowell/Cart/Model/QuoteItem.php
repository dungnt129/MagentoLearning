<?php

namespace Cowell\Cart\Model;

class QuoteItem extends \Magento\Framework\Model\AbstractModel
{

    const ProductypeConfigurable = 'configurable';

    protected function _construct()
    {
        $this->_init('Cowell\Cart\Model\ResourceModel\Item');
    }

    public function getQuoteItemCollection()
    {
        $collection = $this->getCollection();
        return $collection;
    }

    /*
     * Get Old Qty
     * @return array
     *
     * Auth: H6iennv244
     * Created : 20-09-2017
     */
    public function getOldQty($itemId){
        $quoteItem = $this->getQuoteItemCollection()
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
        $quoteItem = $this->getQuoteItemCollection()
            ->addFieldToFilter('parent_item_id', ['eq' => $itemId])
            ->getData();
        return $quoteItem;
    }

    public function getAttributeQuoteItem($now)
    {
        $collection = $this->getQuoteItemCollection();
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
            ->order("main_table.parent_item_id"," asc")
            ->order("main_table.item_id"," asc");

//            echo $collection->getSelect();die;
        $attributes = $collection->getData();

        return $attributes;
    }
    

}