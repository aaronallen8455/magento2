<?php


namespace AAllen\Images\Controller\Adminhtml\Image;

use AAllen\Images\Api\ImageRepositoryInterface;
use AAllen\Images\Model\Image;
use AAllen\Images\Model\ImageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;

class Delete extends \AAllen\Images\Controller\Adminhtml\Image
{
    protected $fileDriver;

    protected $imageRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        File $file,
        ImageRepositoryInterface $imageRepository
    )
    {
        $this->fileDriver = $file;
        $this->imageRepository = $imageRepository;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('image_id');
        if ($id) {
            try {
                // init model and delete
                /** @var Image $model */
                $model = $this->imageRepository->getById($id);

                // delete the image file
                $mediaDirectory = $this->_objectManager->get(
                    'Magento\Framework\Filesystem'
                )->getDirectoryWrite(
                    DirectoryList::MEDIA
                );
                $filePath = $mediaDirectory->getAbsolutePath() . Image::IMAGE_PATH . $model->getFileName();
                if ($this->fileDriver->isExists($filePath)) {
                    $this->fileDriver->deleteFile($filePath);
                }

                $this->imageRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccess(__('You deleted the Image.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['image_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a Image to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
