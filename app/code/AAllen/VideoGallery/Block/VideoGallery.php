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
use Magento\Catalog\Model\ResourceModel\Product\Gallery;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Element\Template;
use Magento\ProductVideo\Setup\InstallSchema;

class VideoGallery extends Template
{
    /** @var ProductRepositoryInterface $productRepo */
    protected $productRepo;

    /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /** @var ResourceConnection $_resource */
    protected $_resource;

    /** @var CategoryRepositoryInterface $catRepo */
    protected $catRepo;

    /** @var string $_html */
    protected $_html = '';

    /**
     * VideoGallery constructor.
     * @param Template\Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ResourceConnection $resourceConnection
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ResourceConnection $resourceConnection,
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
        $galleryTable = Gallery::GALLERY_VALUE_TABLE;
        $videoTable = InstallSchema::GALLERY_VALUE_VIDEO_TABLE;
        // get product id's and their matching video urls
        $results = $this->_resource->getConnection()->fetchAll(
            "SELECT a.entity_id, b.url FROM $galleryTable AS a JOIN $videoTable As b ON a.value_id=b.value_id GROUP BY b.url"
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
                    if ($category->getId() == 2) break; // lowest category level
                    $tier = [$category->getName() => $cats];
                    $cats = $tier;
                    //if ($category->getParentId() == 0) break;
                }

                $tree = array_merge_recursive($tree, $cats);
            }
        }

        return $tree;
    }

    /**
     * Get Html string
     *
     * @return string
     */
    public function getTreeHtml()
    {
        if (!$this->hasData('tree')) {
            $this->setData('tree', $this->getTree());
        }
        $tree = $this->getData('tree');

        // build the html string.
        array_walk($tree, array($this, 'walker'));

        return $this->_html;
    }

    /**
     * Used to recursively walk over the tree array
     *
     * @param $value
     * @param $key
     */
    private function walker($value, $key) {
        // determine if it's a category or an endpoint
        if (isset($value['url']) && isset($value['name'])) {
            $vendor = strstr($value['url'], 'youtube') ? 'youtube' : 'vimeo';
            preg_match('/[\w\d]+$/', $value['url'], $code);
            $this->addToHtml("<li><a href='#' data-code='{$code[0]}' data-vendor='$vendor'>{$value['name']}</a></li>");
        }else{
            // build list and recurse through next category
            $this->addToHtml("<li>$key");
            $this->addToHtml("<ul>");
            array_walk($value, array($this, 'walker'));
            $this->addToHtml('</ul></li>');
        }
    }

    /**
     * Append to the html string
     *
     * @param $string
     */
    protected function addToHtml($string)
    {
        $this->_html .= $string;
    }
}