<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/22/2017
 * Time: 9:17 AM
 */

namespace Cowll\EShopper\Block;


use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
class CategoryList extends Template
{
    protected function _beforeToHtml()
    {
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
        $categoryHelper = $objectManager->get('\Magento\Catalog\Helper\Category'); /* @var $categoryHelper \Magento\Catalog\Helper\Category*/
        $categories = $categoryHelper->getStoreCategories();
        $this->setData('categories',$categories);
    }
}