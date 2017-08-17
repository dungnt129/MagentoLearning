<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 8/15/2017
 * Time: 3:56 PM
 */
namespace Trymsunsoan\Banner\Model\Banner\Source;
class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $banner;

    public function __construct(\Trymsunsoan\Banner\Model\Banner $banner)
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