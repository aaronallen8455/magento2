<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/28/2016
 * Time: 9:32 PM
 */

namespace AAllen\Showcase\Block\Widget;


use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

class Showcase extends Template implements BlockInterface
{
    /** @var  array $_tabs */
    protected $_tabs;

    /** @var  string $_defaultHtml */
    protected $_defaultHtml = '';

    /**
     * Showcase constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data
    )
    {
        $this->_isScopePrivate = true;
        $this->setTemplate('AAllen_Showcase::showcase.phtml');

        parent::__construct($context, $data);
    }

    /**
     * Return an array with data for each tab
     * @return array
     */
    public function getTabs()
    {
        if (empty($this->_tabs)) {
            // parse conditions
            $conditions = $this->getData('conditions_encoded');
            $conditions = str_replace(['`', '[', ']'], ['"', '{', '}'], $conditions);
            $conditions = unserialize($conditions);

            // get array of data for all enabled tabs that have at least one condition
            $data = [];
            for ($i=1; $i<7; $i++) {
                if ($this->getData("tab{$i}_show") &&
                    ($name = $this->getData("tab{$i}_name")) &&
                    $c = array_intersect_key($conditions, array_flip(preg_grep("/$i--/", array_keys($conditions))))) {

                    // rename the key for each condition, setting id to 1
                    $cond = [];
                    $p = 1;
                    foreach ($c as $value) {
                        $cond['1--' . $p++] = $value;
                    }

                    // assign the info element
                    $cond[1] = $conditions[$i];

                    // encode the conditions
                    $cond = serialize($cond);
                    $cond = str_replace(['"', '{', '}'], ['`', '[', ']'], $cond);

                    $data[$i] = [
                        'name' => $name,
                        'conditions' => $cond,
                        'tab_index' => $i
                    ];
                }
            }
            $this->_tabs = $data;
        }

        return $this->_tabs;
    }

    public function getDefaultHtml($encode = false)
    {
        $tabId = $this->getDefaultTabId();
        $tabs = $this->getTabs();

        if (empty($this->_defaultHtml) && isset($tabs[$tabId]['conditions'])) {
            $tabs[$tabId]['conditions'] = str_replace(['`', '[', ']', '|'], ['"', '{', '}', '\\'], $tabs[$tabId]['conditions']);

            /** @var ProductsList $block */
            $block = $this->_layout->createBlock('Magento\CatalogWidget\Block\Product\ProductsList');

            $block->setTemplate('Magento_CatalogWidget::product/widget/content/grid.phtml');

            $block->setData('conditions_encoded', $tabs[$tabId]['conditions']);

            $block->setData('show_pager', false);

            $block->setData('products_count', 50);

            $this->_defaultHtml = $block->toHtml();
        }
        if ($encode) return urlencode($this->_defaultHtml); // if passing through json
        return $this->_defaultHtml;
    }

    public function getDefaultTabId()
    {
        return $this->getRequest()->getParam('tab', 1);
    }
}