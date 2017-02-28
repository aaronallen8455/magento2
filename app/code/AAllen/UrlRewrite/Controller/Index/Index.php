<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/21/2017
 * Time: 12:49 AM
 */

namespace AAllen\UrlRewrite\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $pageFactory;

    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}