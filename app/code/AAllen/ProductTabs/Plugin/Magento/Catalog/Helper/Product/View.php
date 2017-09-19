<?php


namespace AAllen\ProductTabs\Plugin\Magento\Catalog\Helper\Product;

use AAllen\ProductTabs\Model\ResourceModel\Tab\Collection;
use AAllen\ProductTabs\Model\ResourceModel\Tab\CollectionFactory;
use Magento\Framework\View\Result\Page;

class View
{
    /** @var  \AAllen\ProductTabs\Model\ResourceModel\Tab\Collection */
    protected $tabCollection;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->tabCollection = $collectionFactory->create();
    }

    public function beforePrepareAndRender(
        \Magento\Catalog\Helper\Product\View $subject, Page $resultPage, ...$args
    ) : array
    {
        $layout = $resultPage->getLayout();

        $detailsBlock = $layout->getBlock('product.info.details');

        // add tabs to the details block
        /** @var \AAllen\ProductTabs\Api\Data\TabInterface $tab */
        foreach ($this->tabCollection->addOrder('position', Collection::SORT_ORDER_ASC) as $tab)
        {
            $name = "tab_" . $tab->getTabId();
            $tabBlock = $layout->createBlock(
                "AAllen\ProductTabs\Block\Tab",
                $name,
                ['tab' => $tab, 'data' => ['title' => __($tab->getLabel())]]
            );
            $detailsBlock->append($tabBlock);
            $layout->addToParentGroup($name,'detailed_info');
        }

        array_unshift($args, $resultPage);

        return $args;
    }
}
