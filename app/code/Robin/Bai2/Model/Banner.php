<?php
namespace Robin\Bai2\Model;
class Banner extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Robin\Bai2\Model\ResourceModel\Banner');
    }

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}