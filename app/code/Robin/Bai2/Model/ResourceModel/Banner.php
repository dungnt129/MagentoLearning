<?php
namespace Robin\Bai2\Model\ResourceModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        // Table name + primary key column
        $this->_init('banner', 'id');
    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {

        $image = $object->getData('image');
        $old_image = $object->getOrigData('image');
        if($image != null && $old_image != $image)
        {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get('Robin\Bai2\BannerImageUpload');
            $imageUploader->moveFileFromTmp($image);
        }

        return $this;
    }

}