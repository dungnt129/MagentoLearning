<?php

namespace Robin\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Robin\Banner\Model\BannerFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Robin_Banner::save';

    protected $jsonFactory;
    protected $bannerFactory;

    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        BannerFactory $bannerFactory
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * Load layout and set active menu
     */

    public function execute()
    {
       $resultJson = $this->jsonFactory->create();
       $error = false;
       $messages = [];

       //Get data
        $postItems = $this->getRequest()->getParam('items',[]);
        var_dump($postItems); die();
    }
}
