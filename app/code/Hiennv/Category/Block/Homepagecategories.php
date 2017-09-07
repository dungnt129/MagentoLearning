<?php

namespace Hiennv\Category\Block;

class Homepagecategories extends \Magento\Framework\View\Element\Template {

    protected $_categoryHelper;
    protected $categoryFlatConfig;
    protected $topMenu;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Hiennv\Category\Block\Html\Topmenu $topMenu
    ) {
        $this->_categoryHelper = $categoryHelper;
        $this->categoryFlatConfig = $categoryFlatState;
        $this->topMenu = $topMenu;
        parent::__construct($context);
    }
    /**
     * Return categories helper
     */
    public function getCategoryHelper()
    {
        return $this->_categoryHelper;
    }
    /**
     * Return top menu html
     * getHtml($outermostClass = '', $childrenWrapClass = '', $limit = 0)
     * example getHtml('level-top', 'submenu', 0)
     */
    public function getHtml()
    {
        return $this->topMenu->getHtml();
    }
}
