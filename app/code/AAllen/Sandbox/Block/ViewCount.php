<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 1/6/2017
 * Time: 3:09 AM
 */

namespace AAllen\Sandbox\Block;


use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Reports\Model\ResourceModel\Product\Collection;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory;

class ViewCount extends Template
{
    protected $productFactory;

    protected $_eventTypeFactory;

    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $factory,
        \Magento\Reports\Model\Event\TypeFactory $eventTypeFactory,
        array $data = []
    ) {
        $this->productFactory = $factory;
        $this->_eventTypeFactory = $eventTypeFactory;

        parent::__construct($context, $data);
    }

    public function getViews()
    {
        $eventTypes = $this->_eventTypeFactory->create()->getCollection();
        foreach ($eventTypes as $eventType) {
            if ($eventType->getEventName() == 'catalog_product_view') {
                $productViewEvent = (int)$eventType->getId();
                break;
            }
        }

        //$storeIds = $this->_storeManager->getWebsite()->getStoreIds();
        //$storeId = array_pop($storeIds);
        /** @var Collection $collection */
        $collection = $this->productFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->getSelect()->reset()->from(
            ['report_table_views' => 'report_event'],
            ['views' => 'COUNT(report_table_views.event_id)']
        )->join(
            ['e' => 'catalog_product_entity'],
            'e.entity_id = report_table_views.object_id'
        )->where(
            'report_table_views.event_type_id = ?',
            $productViewEvent
        )->group(
            'e.entity_id'
        )->order(
            'views DESC'
        )->having(
            'COUNT(report_table_views.event_id) > ?',
            0
        );

        //$collection->addAttributeToSelect('*')
        //    ->setStoreId($storeId)
        //    ->addStoreFilter($storeId)
        //    ->load();

        $collection->setPageSize(3);
        $collection->setCurPage(1);

        $result = '';

        /** @var Product $item */
        foreach ($collection as $item) {
            $result .= $item->getViews() . ' ' . $item->getName() . ' ';
        }

        return $result;
    }
}