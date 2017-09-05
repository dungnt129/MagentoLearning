<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/30/2017
 * Time: 2:01 PM
 */
namespace Cowll\EShopper\Block\Product;
class ProductsList extends \Magento\CatalogWidget\Block\Product\ProductsList
{
    protected function _beforeToHtml()
    {
        $this->setProductCollection($this->createCollection());
        return parent::_beforeToHtml();
    }
}