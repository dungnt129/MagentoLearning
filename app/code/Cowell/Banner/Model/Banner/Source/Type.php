<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/31/2017
 * Time: 3:29 PM
 */

namespace Cowell\Banner\Model\Banner\Source;

use Magento\Framework\Data\OptionSourceInterface;
class Type implements \Magento\Framework\Option\ArrayInterface
{
    protected $banner;

    public function __construct(\Cowell\Banner\Model\Banner $banner)
    {
        $this->banner = $banner;
    }

    /**
     * Get status options
     */
    public function toOptionArray()
    {
        $availableOptions = $this->banner->getAvailableTypes();
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