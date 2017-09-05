<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/30/2017
 * Time: 1:34 PM
 */
namespace Cowll\EShopper\Block\Catalog\Product;
class View extends \Magento\Catalog\Block\Product\View
{
    /**
     * Retrieve current product model
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        die('x');

        if (!$this->_coreRegistry->registry('product') && $this->getProductId()) {
            $product = $this->productRepository->getById($this->getProductId());
            $this->_coreRegistry->register('product', $product);
        }
        return $this->_coreRegistry->registry('product');
    }
}