<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/29/2016
 * Time: 8:36 PM
 */

namespace AAllen\CatMenu\Controller\Index;


use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\View\Result\Layout;
use Magento\Framework\View\Result\PageFactory;


class Index extends Action
{
    /** @var  PageFactory $_resultPageFactory */
    protected $_resultPageFactory;

    protected $_layout;

    public function __construct(Context $context, PageFactory $pageFactory, LayoutInterface $layout)
    {
        $this->_resultPageFactory = $pageFactory;
        $this->_layout = $layout;

        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $catId = $this->getRequest()->getParam('category_id');

        //redirect if no post
        if (empty($catId)) {
            return $this->resultRedirectFactory->create()->setRefererUrl();
        }

        /** @var ProductsList $block */
        $block = $resultPage->getLayout()->createBlock('Magento\CatalogWidget\Block\Product\ProductsList');

        $block->setTemplate('Magento_CatalogWidget::product/widget/content/grid.phtml');

        $conditions = [
            1 => [
                'type' => 'Magento\CatalogWidget\Model\Rule\Condition\Combine',
                'aggregator' => 'all',
                'value' => 1,
                'new_child' => null
            ],
            '1--1' => [
                'type' => 'Magento\CatalogWidget\Model\Rule\Condition\Product',
                'attribute' => 'category_ids',
                'operator' => '==',
                'value' => $catId
            ]
        ];

        $block->setData('conditions_encoded', serialize($conditions));
        //$block->setData('conditions_encoded', 'a:2:{i:1;a:4:{s:4:"type";s:50:"Magento\CatalogWidget\Model\Rule\Condition\Combine";s:10:"aggregator";s:3:"all";s:5:"value";s:1:"1";s:9:"new_child";s:0:"";}s:4:"1--1";a:4:{s:4:"type";s:50:"Magento\CatalogWidget\Model\Rule\Condition\Product";s:9:"attribute";s:12:"category_ids";s:8:"operator";s:2:"==";s:5:"value";s:1:"7";}}');

        $block->setData('show_pager', false);

        $block->setData('products_count', 50);

        echo $block->toHtml();

        $this->resultRedirectFactory->create()->setRefererUrl();
        return null;
        //return $resultPage;
    }
}