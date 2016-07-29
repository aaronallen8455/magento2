<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/2/2016
 * Time: 3:20 AM
 */

namespace AAllen\Sandbox\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\LayoutInterface;

class Index extends Action
{
    /** @var LayoutInterface $_layout */
    protected $_layout;

    public function __construct(Context $context, LayoutInterface $layout)
    {
        $this->_layout = $layout;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('category_id');

        echo $this->_layout->createBlock('Magento\CatalogWidget\Block\Product\ProductsList', 'category.products')
            ->setTemplate('Magento_CatalogWidget::product/widget/content/grid.phtml')
            ->setCategoryId($id)
            ->toHtml();

        return null;
    }
}