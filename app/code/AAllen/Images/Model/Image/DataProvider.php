<?php


namespace AAllen\Images\Model\Image;

use AAllen\Images\Model\Image;
use AAllen\Images\Model\ResourceModel\Image\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Filesystem;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    protected $mediaDirectory;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Filesystem $filesystem,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
            $this->appendImage($model);
        }
        $data = $this->dataPersistor->get('aallen_images_image');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->appendImage($model);
            $this->dataPersistor->clear('aallen_images_image');
        }
        
        return $this->loadedData;
    }

    protected function appendImage(Image $model)
    {
        $this->loadedData[$model->getId()]['image'] = [
            [
                'url' => $model->getUrl(),
                'name' => $model->getFileName(),
                'size' => $this->mediaDirectory->stat($model::IMAGE_PATH . $model->getFileName())['size'],
                'file' => $model->getFileName(),
                'type' => 'image/jpeg'
            ]
        ];
    }
}
