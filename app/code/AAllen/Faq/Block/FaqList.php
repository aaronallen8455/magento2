<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 9/6/2016
 * Time: 2:25 AM
 */

namespace AAllen\Faq\Block;


use AAllen\Faq\Model\Faq;
use AAllen\Faq\Model\ResourceModel\Faq\Collection;
use AAllen\Faq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Framework\View\Element\Template;

class FaqList extends Template
{
    /**
     * @var Collection
     */
    protected $collection;

    public function __construct(
        Template\Context $context,
        CollectionFactory $faqRepository,

        array $data
    )
    {
        $this->collection = $faqRepository->create();
        parent::__construct($context, $data);
    }

    /**
     * @return Faq[]
     */
    public function getFaqs()
    {
        $array = $this->collection->addOrder('position', Collection::SORT_ORDER_ASC)->getItems();
        return array_values($array);
    }
}