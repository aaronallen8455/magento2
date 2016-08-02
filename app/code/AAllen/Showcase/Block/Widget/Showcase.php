<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/28/2016
 * Time: 9:32 PM
 */

namespace AAllen\Showcase\Block\Widget;


use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

class Showcase extends Template implements BlockInterface
{
    /** @var  Collection */
    protected $_categoryCollectionFactory;

    public function __construct(
        Context $context,
        CollectionFactory $categoryCollection,
        array $data
    )
    {
        $this->_categoryCollectionFactory = $categoryCollection;
        $this->_isScopePrivate = true;
        $this->setTemplate('AAllen_Showcase::showcase.phtml');

        parent::__construct($context, $data);
    }

    public function getTabs()
    {

    }

    public function getWidgetHtml()
    {
        $catId = $this->getRequest()->getParam('cat');

        if (filter_var($catId, FILTER_VALIDATE_INT, ['min_range' => 0])) {

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
                    'value' => $catId
                ]
            ];

            $block->setData('conditions_encoded', serialize($conditions));

            $block->setData('show_pager', true);

            $block->setData('products_per_page', 50);

            return $block->toHtml();
        }
        return '';
    }
}