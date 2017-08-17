<?php

namespace Trymsunsoan\Banner\Model;
class Banner extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    protected function _construct()
    {
        $this->_init('Trymsunsoan\Banner\Model\ResourceModel\Banner');
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

}