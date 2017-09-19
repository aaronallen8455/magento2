<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/30/2017
 * Time: 5:05 AM
 */

namespace AAllen\Sandbox\Ui;


use Magento\Framework\Data\OptionSourceInterface;

class CcTypes implements OptionSourceInterface
{

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Grid\Collection
     */
    protected $salesCollection;

    protected $collectionFactory;

    protected $options;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $collectionFactory
    ) {
        $this->salesCollection = $collectionFactory->getReport("sales_order_grid_data_source");
    }

    public function toOptionArray()
    {
        if ($this->options === null) {

            $lastItem = "";
            foreach ($this->salesCollection->addOrder("payment_method") as $order)
            {
                $ccType = $order->getPaymentMethod();
                if ($lastItem !== $ccType)
                {
                    $this->options[] = [
                        'value' => $ccType,
                        'label' => $ccType
                    ];

                    $lastItem = $ccType;
                }
            }
        }

        return $this->options;
    }
}