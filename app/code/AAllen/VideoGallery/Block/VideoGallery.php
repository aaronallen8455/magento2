<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 9/4/2016
 * Time: 5:59 AM
 */

namespace AAllen\VideoGallery\Block;


use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class VideoGallery extends Template
{
    protected $productRepo;
    protected $searchCriteriaBuilder;
    protected $_resource;
    protected $catRepo;
    protected $_html = '';

    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        array $data
    )
    {
        $this->catRepo = $categoryRepository;
        $this->_resource = $resourceConnection;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepo = $productRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get tree of category names with product/videoUrl pair endpoints
     *
     * @return array
     */
    protected function getTree()
    {
        // get product id's and their matching video urls
        $results = $this->_resource->getConnection()->fetchAll(
            'SELECT a.entity_id, b.url FROM catalog_product_entity_media_gallery_value AS a JOIN catalog_product_entity_media_gallery_value_video As b ON a.value_id=b.value_id GROUP BY b.url'
        );

        $filteredProducts = [];

        foreach ($results as $item) {
            /** @var Product $product */
            $product = $this->productRepo->getById($item['entity_id']);
            $catIds = $product->getCategoryIds();
            // remove categories that aren't endpoints
            foreach ($catIds as $catId) {
                /** @var Category $cat */
                $cat = $this->catRepo->get($catId);
                $catIds = array_diff($catIds, $cat->getParentIds());
            }
            $filteredProducts[] = [
                'url' => $item['url'],
                'product' => $product,
                'catIds' => $catIds
            ];
        }

        $tree = [];

        // build tree from filtered products
        /** @var Product $product */
        foreach ($filteredProducts as $item) {
            foreach ($item['catIds'] as $catId) {
                $cats = [];

                /** @var Category $category */
                $category = $this->catRepo->get($catId);

                $cats[$category->getName()][] = ['url' => $item['url'], 'name' => $item['product']->getName()];

                while ($category = $category->getParentCategory()) {
                    $tier = [$category->getName() => $cats];
                    $cats = $tier;
                    if ($category->getParentId() == 0) break;
                }

                $tree = array_merge_recursive($tree, $cats);
            }
        }

        return $tree;
    }

    public function getTreeHtml()
    {
        if (!$this->hasData('tree')) {
            $this->setData('tree', $this->getTree());
        }
        $tree = $this->getData('tree');

        $this->addToHtml('<div class="video-gallery-tree"><ul>');

        // build the html string.
        array_walk($tree, array($this, 'walker'));

        $this->addToHtml('</ul></div>');

        return $this->_html;
    }

    private function walker($value, $key) {
        // determine if it's a category or an endpoint
        if (isset($value['url']) && isset($value['name'])) {
            preg_match('/[\w\d]+$/', $value['url'], $code);
            $this->addToHtml("<li><a href='#' data-code='{$code[0]}'>{$value['name']}</a></li>");
        }else{
            // build list and recurse through next category
            $this->addToHtml("<li>$key");
            $this->addToHtml("<ul>");
            array_walk($value, array($this, 'walker'));
            $this->addToHtml('</ul></li>');
        }
    }

    protected function addToHtml($string)
    {
        $this->_html .= $string;
    }
}