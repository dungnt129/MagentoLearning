<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dmit\Banner\Controller\Adminhtml\Index;

use Dmit\Banner\Model\BannerFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dmit_Banner::save';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $jsonFactory;
    protected $bannerFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        BannerFactory $bannerFactory
    ) {
        $this->jsonFactory   = $jsonFactory;
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context);
    }

    /**
     * Edit CMS page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $jsonResult = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        // Get data
        $postItems = $this->getRequest()->getParam('items', []);
        foreach (array_keys($postItems) as $bannerId) {
            try {
                $banner = $this->bannerFactory->create();
                $banner->load($bannerId);
                $banner->setData($postItems[(string)$bannerId]);
                $banner->save();
            } catch (\Exception $e) {
                $messages[] = __('Error inline edit: '. $e->getMessage());
                $error = true;
            }
        }

        return $jsonResult->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
