<?php
/**
 * Created by PhpStorm.
 * User: DuongHT
 * Date: 2017-08-14
 * Time: 10:33 SA
 */

namespace Dmit\Banner\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Dmit\Banner\Model\ResourceModel\Banner\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // Lấy ra các bản ghi đang chọn sử dụng filter (Magento\Ui\Component\MassAction\Filter)
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        // Đếm số bản ghi đang chọn
        $collectionSize = $collection->getSize();

        // Xóa bản ghi đang chọn
        foreach ($collection as $banner) {
            $banner->delete();
        }

        // Thêm thông báo xóa thành công
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        // Redirect lại về trang List
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}