<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/8/2016
 * Time: 8:33 PM
 */

namespace AAllen\PriceUpdate\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('AAllen_PriceUpdate::update');
        $resultPage->addBreadcrumb(__('Pricing'), __('Pricing'));
        $resultPage->addBreadcrumb(__('Mass Price Update'), __('Mass Price Update'));
        $resultPage->getConfig()->getTitle()->prepend(__('Pricing Update'));

        return $resultPage;
    }

    /**
     * Is the user allowed to update prices.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('AAllen_PriceUpdate::update');
    }
}