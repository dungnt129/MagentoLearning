<?php
/**
 * Created by PhpStorm.
 * User: DuongHT
 * Date: 2017-08-09
 * Time: 2:18 CH
 */


namespace Dmit\Banner\Model\Banner\Source;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $banner;

    public function __construct(\Dmit\Banner\Model\Banner $banner)
    {
        $this->banner = $banner;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->banner->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}