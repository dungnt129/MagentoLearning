<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Robin\Banner\Block\Adminhtml\Banner\Edit;

use Magento\Backend\Block\Widget\Context;

/**
 * Class GenericButton
 */
class GenericButton
{
    protected $context;
    protected $bannerFactory;

    public function __construct(
        Context $context,
        \Robin\Banner\Model\BannerFactory $bannerFactory
    )
    {
        $this->context = $context;
        $this->bannerFactory = $bannerFactory;
    }
    /**
     * Return Banner ID
     */
    public function getBannerId()
    {

        $id = $this->context->getRequest()->getParam('id');
        $banner = $this->bannerFactory->create()->load($id);
        if ($banner->getId())
            return $id;
        return null;
    }
    /**
     * Generate url by route and parameters
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
