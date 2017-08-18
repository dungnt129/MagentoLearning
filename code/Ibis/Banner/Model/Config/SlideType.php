<?php
namespace Ibis\Banner\Model\Config;

class SlideType implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'bxslider', 'label' => __('bxslider')],
            ['value' => 'flexslider', 'label' => __('flexslider')]
        ];
    }
}