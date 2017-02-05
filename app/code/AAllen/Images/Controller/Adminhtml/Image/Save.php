<?php


namespace AAllen\Images\Controller\Adminhtml\Image;

use AAllen\Images\Model\Image;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Driver\File;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    protected $imageUploader;

    protected $fileDriver;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        ImageUploader $imageUploader,
        File $file
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        $this->fileDriver = $file;

        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('image_id');
        
            $model = $this->_objectManager->create('AAllen\Images\Model\Image')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This Image no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            $model->setData($data);

            $oldFileName = $model->getFileName();
            $model->setFileName($data['image'][0]['name']);
        
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the Image.'));
                $this->dataPersistor->clear('aallen_images_image');

                // delete old image if it was changed
                if ($oldFileName && $id) {
                    $mediaDirectory = $this->_objectManager->get(
                        'Magento\Framework\Filesystem'
                    )->getDirectoryWrite(
                        DirectoryList::MEDIA
                    );
                    $filePath = $mediaDirectory->getAbsolutePath() . Image::IMAGE_PATH . $model->getFileName();
                    if ($this->fileDriver->isExists($filePath)) {
                        $this->fileDriver->deleteFile($filePath);
                    }
                }

                // move image out of temp folder
                $this->imageUploader->moveFileFromTmp($model->getFileName());

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['image_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Image.'));
            }
        
            $this->dataPersistor->set('aallen_images_image', $data);
            return $resultRedirect->setPath('*/*/edit', ['image_id' => $this->getRequest()->getParam('image_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
