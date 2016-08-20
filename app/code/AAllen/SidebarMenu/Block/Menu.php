<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/19/2016
 * Time: 10:08 PM
 */

namespace AAllen\SidebarMenu\Block;


use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;

class Menu extends Template
{
    /** @var CategoryRepositoryInterface $_categoryRepo */
    protected $_categoryRepo;

    /**
     * Menu constructor.
     * @param Template\Context $context
     * @param CategoryRepositoryInterface $categoryRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CategoryRepositoryInterface $categoryRepository,
        array $data
    ) {
        parent::__construct($context, $data);

        $this->_categoryRepo = $categoryRepository;

        $this->setTemplate('AAllen_SidebarMenu::menu.phtml');
    }

    /**
     * Get menu structure as json
     *
     * @return string
     */
    public function getJson()
    {
        $root = $this->_categoryRepo->get(Category::TREE_ROOT_ID);

        $array = $this->processChildren($root);

        $json = json_encode($array);
        $json = str_replace("'", '', $json); // remove apostrophes, would break json

        return $json;
    }

    /**
     * Recurse through the category tree to build menu structure
     *
     * @param Category $category
     * @return array
     */
    protected function processChildren(Category $category)
    {
        $result = [];

        foreach ($category->getChildrenCategories() as $cat) {
            // check if this is an endpoint
            if ($cat->getProductCount() === 1) {
                /** @var Product $product */
                $product = array_values($cat->getProductCollection()->getItems())[0];

                $result[$cat->getName()] = $product->getProductUrl();
            } else {
                // recurse through next level
                $result[$cat->getName()] = $this->processChildren($cat);
            }
        }

        return $result;
    }
}