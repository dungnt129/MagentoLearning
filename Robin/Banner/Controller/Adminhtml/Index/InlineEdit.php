<?php

namespace Robin\Banner\Controller\Adminhtml\Index;

use Braintree\Exception;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Robin\Banner\Model\BannerFactory;

class InlineEdit extends \Magento\Backend\App\Action
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



    public function execute()
    {
       $resultJson = $this->jsonFactory->create();
       $error = false;
       $messages = [];

       //Get data
        $postItems = $this->getRequest()->getParams('item', []);

        foreach (array_keys($postItems) as $bannerId) {
            try {
                $banner = $this->bannerFactory->create();
                $banner->load($bannerId);
                $banner->setData($postItems[(string)$bannerId]);
                $banner->save();
            } catch (\Exception $e) {
                $messages[] = __('Something went wrong');
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
