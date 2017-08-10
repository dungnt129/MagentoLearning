<?php
namespace Cowll\Banner\Controller\Adminhtml\Index;
class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Cowll_Banner::delete';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Cowll\Banner\Model\Banner');
                $model->load($id);
                $id = $model->getId();
                $model->delete();
                $this->messageManager->addSuccess(__('Delete image success.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Delete error, please try again.'));
        return $resultRedirect->setPath('*/*/');
    }
}