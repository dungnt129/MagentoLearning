<?php
namespace Trymsunsoan\Banner\Controller\Adminhtml\Index;
class NewAction extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Trymsunsoan_Banner::save';
    protected $resultForwardFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
