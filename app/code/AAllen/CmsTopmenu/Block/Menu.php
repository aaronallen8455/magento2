<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/23/2016
 * Time: 10:34 PM
 */

namespace AAllen\CmsTopmenu\Block;


use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\ResourceModel\Page\Collection;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class Menu extends Template
{
    /** @var  Collection */
    protected $pageCollection;

    protected $pageHelper;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        \Magento\Cms\Helper\Page $pageHelper,
        array $data
    )
    {
        $this->pageCollection = $collectionFactory->create();
        $this->pageHelper = $pageHelper;

        $this->setTemplate('topmenu.phtml');

        parent::__construct($context, $data);
    }

    public function getHtml()
    {
        $html = '';
        // a list of all cms pages

        $pages = $this->pageCollection->addOrder('title', Collection::SORT_ORDER_DESC);

        /** @var Page $page */
        foreach ($pages as $page) {
            $html .= '<li>';
            $html .= '<a href="' . $this->pageHelper->getPageUrl($page->getId()) . '">';
            $html .= __($page->getTitle());
            $html .= '</a></li>';
        }

        return $html;
    }
}