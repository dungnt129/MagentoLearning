<?php
namespace Dmit\Jointable\Model;

class Joint extends \Magento\Framework\Model\AbstractModel implements \Dmit\Jointable\Api\Data\JointInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'dmit_jointable_joint';

    protected function _construct()
    {
        $this->_init('Dmit\Jointable\Model\ResourceModel\Joint');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
