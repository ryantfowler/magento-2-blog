<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Blog
 * @copyright   Copyright (c) 2018 Mageplaza (http://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\Blog\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action\Context;
use Magento\Cms\Block\Page;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Mageplaza\Blog\Controller\Adminhtml\Comment;
use Mageplaza\Blog\Model\CommentFactory;
use Mageplaza\Blog\Model\PostFactory;
use Mageplaza\Blog\Model\ResourceModel\Comment\CollectionFactory;

/**
 * Class Edit
 * @package Mageplaza\Blog\Controller\Adminhtml\Comment
 */
class Edit extends Comment
{
    /**
     * Page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public $resultPageFactory;

    /**
     * Edit constructor.
     * @param PageFactory $pageFactory
     * @param CommentFactory $commentFactory
     * @param Registry $coreRegistry
     * @param Context $context
     */
    public function __construct(
        PageFactory $pageFactory,
        CommentFactory $commentFactory,
        Registry $coreRegistry,
        Context $context
    )
    {
        $this->resultPageFactory = $pageFactory;

        parent::__construct($commentFactory, $coreRegistry, $context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Mageplaza\Blog\Model\Comment $comment */
        $comment = $this->initComment();

        if (!$comment) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('*');

            return $resultRedirect;
        }

        $data = $this->_session->getData('mageplaza_blog_comment_data', true);

        if (!empty($data)) {
            $comment->setData($data);
        }

        $this->coreRegistry->register('mageplaza_blog_comment', $comment);


        /** @var \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mageplaza_Blog::comment');

        $title = __('Edit Comment');
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
