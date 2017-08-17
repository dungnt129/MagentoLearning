<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Trymsunsoan\Banner\Block\Adminhtml\Index\Edit;

use Magento\Backend\Block\Widget\Context;


/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    protected $bannerFactory;


    public function __construct(
        Context $context,
        \Trymsunsoan\Banner\Model\BannerFactory $bannerFactory
    ) {
        $this->context = $context;
        $this->bannerFactory = $bannerFactory;
    }

    /**
     * Return Banner ID
     *
     * @return int|null
     */
    public function getBannerId()
    {
        $id = $this->context->getRequest()->getParam('id');
        $banner = $this->bannerFactory->create()->load( $id );
        if( $banner->getId() ){
            return $id;
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
