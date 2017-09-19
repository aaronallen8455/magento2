<?php


namespace AAllen\ProductTabs\Block;


use AAllen\ProductTabs\Api\Data\TabInterface;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\View\Element\Template;

class Tab extends Template
{
    protected $tab;

    protected $blockFilter;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        TabInterface $tab,
        FilterProvider $filterProvider,
        array $data = []
    ) {
        $this->tab = $tab;
        $this->blockFilter = $filterProvider->getBlockFilter();

        parent::__construct($context, $data);
    }

    public function toHtml() : string
    {
        return $this->blockFilter->filter($this->tab->getContent());
    }
}