<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/6/2017
 * Time: 12:53 AM
 */

namespace AAllen\Images\Model\Config\Source;


use AAllen\Images\Model\ResourceModel\Image\Collection;

class ImagesSource implements \Magento\Framework\Option\ArrayInterface
{
    /** @var  Collection */
    protected $imagesCollection;

    public function __construct(\AAllen\Images\Model\ResourceModel\Image\CollectionFactory $collectionFactory)
    {
        $this->imagesCollection = $collectionFactory->create();
    }

    public function toOptionArray()
    {
        $result = [
            ['value' => null, 'label' => 'None']
        ];

        $this->imagesCollection->addFieldToSelect(['title', 'file_name']);

        foreach ($this->imagesCollection as $item) {
            $result[] = [
                'value' => $item->getId(), 'label' => $item->getTitle()
            ];
        }

        return $result;
    }
}