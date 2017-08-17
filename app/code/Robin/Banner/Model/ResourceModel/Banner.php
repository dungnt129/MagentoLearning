<?php
/**
 * Created by PhpStorm.
 * User: nguyenduyhung
 * Date: 8/15/17
 * Time: 5:13 PM
 */

namespace Robin\Banner\Model\ResourceModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    protected  function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('banner', 'id');

    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $image = $object->getData('image');
        if ($image != null) {
            $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Robin\Banner\BannerImageUpload');
            $imageUploader->moveFileFromTmp($image);
        }

        return $this;

    }
}