<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/2/2016
 * Time: 3:20 AM
 */

namespace AAllen\Sandbox\Controller\Box;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Cart;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $customerFactory;
    protected $resultPageFactory;
    /** @var Cart $cart */
    protected $cart;
    protected $coreRegistry;
    protected $productRepo;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CustomerFactory $customerFactory,
        Cart $cart,
        Registry $registry,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->productRepo = $productRepository;
        $this->coreRegistry = $registry;
        $this->customerFactory = $customerFactory;
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
        $this->cart = $cart;
    }

    public function execute()
    {
        // feed product to media gallery
        $product = $this->productRepo->getById(2);
        $this->coreRegistry->register('product', $product);

        $url = '';
        $images = $product->getMediaGalleryImages();
        if ($images instanceof \Magento\Framework\Data\Collection) {
            foreach ($images as $image) {
                /* @var \Magento\Framework\DataObject $image */
                $url = $image->getVideoUrl();
            }
        }


        //youtube api key  AIzaSyDNPeLdIzruUJjoUKnjYI0VcICznNJVBwg



        $resultPage = $this->resultPageFactory->create();

        //\Zend_Debug::dump($url);

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

        //$productFactory = $this->_objectManager->create('\Magento\Catalog\Model\ProductFactory');
        //$product = $productFactory->create();
        //$product->load(20);
//
        //var_dump($this->cart->getQuoteProductIds());
        //$this->cart->addProduct($product);
        $this->cart->truncate();
        $this->cart->save();

        return $resultPage;
    }
}