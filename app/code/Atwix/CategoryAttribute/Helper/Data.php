<?php
/**
 * Class:Categories
 * Sebwite\Sidebar\Model\Config\Source
 *
 * @author      Vasilis Vasiloudis
 * @package     Sebwite\Sidebar
 * @copyright   Copyright (c) 2016, vvasiloud. All rights reserved
 */
namespace Atwix\CategoryAttribute\Helper;

use Magento\Framework\Module\ModuleListInterface;
use Magento\Store\Model\ScopeInterface;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	const XML_PATH_ENABLED    		 			= 'general/enabled';
	const XML_PATH_CATEGORY    		 			= 'general/category';
	const XML_PATH_CATEGORY_DEPTH_LEVEL    		= 'general/categorydepth';
	
	
	/**
     * @var ModuleListInterface
     */
//    protected $_moduleList;
	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
	 * @param ModuleListInterface $moduleList
     */
//	public function __construct(
//	    \Magento\Framework\App\Helper\Context $context,
//        ModuleListInterface $moduleList,
//        \Magento\Store\Model\StoreManagerInterface $storeManager
//	) {
//		$this->_moduleList    = $moduleList;
//        $this->_storeManager = $storeManager;
//		parent::__construct($context);
//	}


    /**
     * @param $xmlPath
     * @param string $section
     *
     * @return string
     */
    public function getCategoryThumbUrl($category)
    {
        $url   = false;
        $image = $category->getImageThumb();
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/category/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
	
}