<?php

namespace Cowell\Genrelist\Block;

class Index extends \Magento\Framework\View\Element\Template {

    protected $_categoryHelper;
    protected $categoryFlatConfig;
    protected $_categoryFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param array $data
     */
    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \Magento\Catalog\Helper\Category $categoryHelper,
    \Magento\Catalog\Model\Category $categoryFactory
    ) {
        $this->_categoryHelper = $categoryHelper;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    /**
     *
     * @return int
     */
    public function getRootCategoryId(){
        return $this->_storeManager->getStore()->getRootCategoryId();
    }


    /**
     * 
     * @param type $catId
     * @return type array
     */
    public function getsubCategories($catId) {
        $cat = $this->_categoryFactory->load($catId);
        $parent = $this->_categoryFactory->getParentId();
        $subcats = $cat->getChildren();
        $subcategories = array();
        foreach (explode(',', $subcats) as $subCatid) {
            $_subCategory = $this->_categoryFactory->load($subCatid);
            $child = $_subCategory->getChildren();
            if ($_subCategory->getIsActive()) {
                $urlSubCategory = $this->_categoryFactory->getCategoryIdUrl();
                $subcategories[] = array(
                    'id' => $_subCategory->getId(),
                    'name' => $_subCategory->getName(),
                    'child' => $child,
                    'parentId' => $parent,
                    'urlSubcategory' => $urlSubCategory,
                );
            }
        }
        return $subcategories;
    }

}
