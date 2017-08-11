<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dungnguyen\Banner\Controller\Adminhtml\Index;

class PostDataProcessor
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * @var \Magento\Framework\View\Model\Layout\Update\ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(\Magento\Framework\Message\ManagerInterface $messageManager) {
        $this->messageManager = $messageManager;
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array $data
     * @return array
     */
//    public function filter($data)
//    {
//        $filterRules = [];
//
//        foreach (['custom_theme_from', 'custom_theme_to'] as $dateField) {
//            if (!empty($data[$dateField])) {
//                $filterRules[$dateField] = $this->dateFilter;
//            }
//        }
//
//        return (new \Zend_Filter_Input($filterRules, [], $data))->getUnescaped();
//    }

    /**
     * Validate post data
     *
     * @param array $data
     * @return bool     Return FALSE if someone item is invalid
     */
//    public function validate($data)
//    {
//        $errorNo = true;
//        if (!empty($data['layout_update_xml']) || !empty($data['custom_layout_update_xml'])) {
//            /** @var $validatorCustomLayout \Magento\Framework\View\Model\Layout\Update\Validator */
//            $validatorCustomLayout = $this->validatorFactory->create();
//            if (!empty($data['layout_update_xml']) && !$validatorCustomLayout->isValid($data['layout_update_xml'])) {
//                $errorNo = false;
//            }
//            if (!empty($data['custom_layout_update_xml'])
//                && !$validatorCustomLayout->isValid($data['custom_layout_update_xml'])
//            ) {
//                $errorNo = false;
//            }
//            foreach ($validatorCustomLayout->getMessages() as $message) {
//                $this->messageManager->addError($message);
//            }
//        }
//        return $errorNo;
//    }

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'image' => __('Image'),
            'link' => __('Link'),
            'status' => __('Status')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}
