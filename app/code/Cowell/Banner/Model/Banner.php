<?php

namespace Cowell\Banner\Model;

class Banner extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Banner's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    const BANNER_LEFT = 1;
    const BANNER_SLIDE = 2;
    const BANNER_FOOTER = 3;

    protected function _construct()
    {
        $this->_init('Cowell\Banner\Model\ResourceModel\Banner');
    }

    /**
     * Prepare banner's statuses.
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * get Option banner type
     * @return array
     */
    public function getAvailableTypes(){
        return [
            self::BANNER_LEFT   =>'Banner Left',
            self::BANNER_SLIDE  => 'Banner slide',
            self::BANNER_FOOTER =>'Banner footer'
        ];
    }

}