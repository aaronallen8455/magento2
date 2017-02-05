<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 1/28/2017
 * Time: 9:29 PM
 */

namespace AAllen\AddToCartButton\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_pageResultFactory;

    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->_pageResultFactory = $pageFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageResultFactory->create();
    }

}