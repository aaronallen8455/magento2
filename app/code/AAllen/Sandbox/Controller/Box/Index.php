<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/2/2016
 * Time: 3:20 AM
 */

namespace AAllen\Sandbox\Controller\Box;


use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $customerFactory;
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $pageFactory, CustomerFactory $customerFactory)
    {
        $this->customerFactory = $customerFactory;
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();

        $block = $resultPage->getLayout()->createBlock(
            'AAllen\Sandbox\Block\Block',
            'testing',
            ['data' => ['test' => '1', 'ok' => 'Bitch']]
        )->setTemplate(
            'AAllen_Sandbox::template.phtml'
        );

        $resultPage->getLayout()->setChild(
            'content',
            $block->getNameInLayout(),
            'test_block'
        );

        $block = $resultPage->getLayout()->createBlock(
            'AAllen\CatMenu\Block\CatMenu',
            'catmenu',
            ['data' => ['test' => '1', 'ok' => 'Bitch']]
        )->setTemplate(
            'AAllen_CatMenu::catmenu.phtml'
        );

        $resultPage->getLayout()->setChild(
            'content',
            $block->getNameInLayout(),
            'cat_menu'
        );

        return $resultPage;
    }
}