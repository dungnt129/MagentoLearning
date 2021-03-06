<?php
/**
 * Copyright © 2015-2017 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\Blog\Controller\Adminhtml\Post;

/**
 * Blog post preview controller
 */
class Preview extends \Magefan\Blog\Controller\Adminhtml\Post
{
    public function execute()
    {
    	try {
            $post = $this->_getModel();
            if (!$post->getId()) {
                throw new \Exception("Item is not longer exist.", 1);
            }

            $previewUrl = $this->_objectManager->get('\Magefan\Blog\Model\PreviewUrl');
            $redirectUrl = $previewUrl->getUrl(
                $post,
                $previewUrl::CONTROLLER_POST
            );

            $this->getResponse()->setRedirect($redirectUrl);

        } catch (\Exception $e) {
            $this->messageManager->addException(
                $e,
                __('Something went wrong %1', $e->getMessage())
            );
            $this->_redirect('*/*/edit', [$this->_idKey => $post->getId()]);
        }
    }
}
