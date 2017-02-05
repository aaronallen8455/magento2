<?php


namespace AAllen\Images\Model;

use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use AAllen\Images\Model\ResourceModel\Image\CollectionFactory as ImageCollectionFactory;
use AAllen\Images\Api\Data\ImageSearchResultsInterfaceFactory;
use AAllen\Images\Api\ImageRepositoryInterface;
use AAllen\Images\Api\Data\ImageInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use AAllen\Images\Model\ResourceModel\Image as ResourceImage;

class ImageRepository implements ImageRepositoryInterface
{

    private $storeManager;

    protected $dataImageFactory;

    protected $ImageCollectionFactory;

    protected $dataObjectProcessor;

    protected $resource;

    protected $dataObjectHelper;

    protected $ImageFactory;

    /**
     * @param ResourceImage $resource
     * @param ImageFactory $imageFactory
     * @param ImageInterfaceFactory $dataImageFactory
     * @param ImageCollectionFactory $imageCollectionFactory
     * @param ImageSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceImage $resource,
        ImageFactory $imageFactory,
        ImageInterfaceFactory $dataImageFactory,
        ImageCollectionFactory $imageCollectionFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->imageFactory = $imageFactory;
        $this->imageCollectionFactory = $imageCollectionFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataImageFactory = $dataImageFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \AAllen\Images\Api\Data\ImageInterface $image
    ) {
        /* if (empty($image->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $image->setStoreId($storeId);
        } */
        try {
            $this->resource->save($image);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the image: %1',
                $exception->getMessage()
            ));
        }
        return $image;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($imageId)
    {
        $image = $this->imageFactory->create();
        $image->load($imageId);
        if (!$image->getId()) {
            throw new NoSuchEntityException(__('Image with id "%1" does not exist.', $imageId));
        }
        return $image;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \AAllen\Images\Api\Data\ImageInterface $image
    ) {
        try {
            $this->resource->delete($image);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Image: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($imageId)
    {
        return $this->delete($this->getById($imageId));
    }
}
