<?php

namespace Cowell\Cart\Model;

class CoreConfig extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Cowell\Cart\Model\ResourceModel\CoreConfig');
    }

    /**
     * Get session cart
     * @return int
     */
    public function getSesstionCart()
    {
        $data = $this->getCollection()
            ->addFieldToFilter('path', ['eq' => 'persistent/options/lifetime'])
            ->getData();
        if ($data) {
            return $data[0]['value'];
        } else {
            return 0;
        }
    }
}