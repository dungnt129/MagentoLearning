<?php
namespace Dmit\Jointable\Model\ResourceModel;
class Joint extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('dmit_jointable_joint','dmit_jointable_joint_id');
    }
}
