<?php
namespace Robin\Bai2\Model\Banner\Source;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    protected $banner;

    public function __construct(\Robin\Bai2\Model\Banner $banner)
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