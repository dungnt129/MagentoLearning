<?php

namespace Cowell\Customer\Model;

class CustomerEntity extends \Magento\Framework\Model\AbstractModel
{


    protected function _construct()
    {
        $this->_init('Cowell\Customer\Model\ResourceModel\Entity');
    }

    /*
     * Get All category
     *
     * @return array
     */
    public function getCustomer($nmId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerCollection = $objectManager->create('\Cowell\Customer\Model\CustomerEntity')->getCollection();
        $customer = $customerCollection
            ->addFieldToFilter('nmid', ['eq' => $nmId])
            ->getData();
        return $customer;
    }
}