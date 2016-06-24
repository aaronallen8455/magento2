<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/29/2016
 * Time: 7:07 PM
 */

namespace AAllen\QuickMenu\Block\Html;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
    /** @var \Magento\Framework\ObjectManagerInterface $_objectManager */
    protected $_objectManager;

    /**
     * Topmenu constructor.
     * @param Template\Context $context
     * @param NodeFactory $nodeFactory
     * @param TreeFactory $treeFactory
     * @param array $data
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(Template\Context $context, NodeFactory $nodeFactory, TreeFactory $treeFactory, array $data, \Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->_objectManager = $objectManager;
        parent::__construct($context, $nodeFactory, $treeFactory, $data);
    }

    public function _construct()
    {
        // use the core template.
        $this->setModuleName('Magento_Theme');
        parent::_construct();
    }

    /**
     * Returns array of menu item's classes
     *
     * @param \Magento\Framework\Data\Tree\Node $item
     * @return array
     */
    protected function _getMenuItemClasses(\Magento\Framework\Data\Tree\Node $item)
    {
        $classes = parent::_getMenuItemClasses($item);

        $a=[];
        //get category ID
        preg_match('/\d+$/', $item->getId(), $a);
        $catId = $a[0];
        //instantiate the category
        $cat = $this->_objectManager->create('Magento\Catalog\Model\Category')->load($catId);
        //determine if the category has only 1 product
        $hasOne = $cat->getProductCount() === 1;
        //set the one product class if so
        if ($hasOne) $classes[] = 'aaron-one-product';

        return $classes;
    }
}