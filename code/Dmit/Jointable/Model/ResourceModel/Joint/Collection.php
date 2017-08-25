<?php
namespace Dmit\Jointable\Model\ResourceModel\Joint;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Dmit\Jointable\Model\Joint','Dmit\Jointable\Model\ResourceModel\Joint');
    }
}
