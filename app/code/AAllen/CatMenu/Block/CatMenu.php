<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/28/2016
 * Time: 9:32 PM
 */

namespace AAllen\CatMenu\Block;


use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Model\Widget;
use Magento\Widget\Model\WidgetFactory;

class CatMenu extends Template
{
    /** @var  Collection */
    protected $_categoryCollectionFactory;

    protected $_widgetFactory;

    public function __construct(
        Context $context,
        CollectionFactory $categoryCollection,
        WidgetFactory $widgetFactory,
        array $data
    )
    {
        $this->_categoryCollectionFactory = $categoryCollection;
        $this->_widgetFactory = $widgetFactory;

        parent::__construct($context, $data);
    }

    public function getCategories()
    {
        /** @var Collection $categories */
        $categories = $this->_categoryCollectionFactory->create();
        $categories->addAttributeToSelect('name');
        $categories->addFieldToFilter('level', 2);

        return $categories;
    }

    public function getWidgets()
    {
        /** @var Widget $widget */
        $widget = $this->_widgetFactory->create();

        return $widget->getWidgetDeclaration('products_list');
    }

    public function getWidgetHtml()
    {
        /** @var ProductsList $block */
        $block = $this->_layout->createBlock('Magento\CatalogWidget\Block\Product\ProductsList');

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
                'value' => 2
            ]
        ];

        $block->setData('conditions_encoded', serialize($conditions));
        //$block->setData('conditions_encoded', 'a:2:{i:1;a:4:{s:4:"type";s:50:"Magento\CatalogWidget\Model\Rule\Condition\Combine";s:10:"aggregator";s:3:"all";s:5:"value";s:1:"1";s:9:"new_child";s:0:"";}s:4:"1--1";a:4:{s:4:"type";s:50:"Magento\CatalogWidget\Model\Rule\Condition\Product";s:9:"attribute";s:12:"category_ids";s:8:"operator";s:2:"==";s:5:"value";s:1:"7";}}');

        $block->setData('show_pager', true);

        $block->setData('products_per_page', 50);

        echo $block->toHtml();
    }
}