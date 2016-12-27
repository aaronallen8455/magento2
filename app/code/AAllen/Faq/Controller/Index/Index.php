<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 9/6/2016
 * Time: 2:36 AM
 */

namespace AAllen\Faq\Controller\Index;


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
        $page = $this->pageFactory->create();

        return $page;
    }
}