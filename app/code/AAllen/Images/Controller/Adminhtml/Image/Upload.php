<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/4/2017
 * Time: 10:58 PM
 */

namespace AAllen\Images\Controller\Adminhtml\Image;


use Magento\Backend\App\Action;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Controller\ResultFactory;

class Upload extends Action
{
    protected $imageUploader;

    public function __construct(
        Action\Context $context,
        ImageUploader $imageUploader
    ) {
        $this->imageUploader = $imageUploader;

        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('image');

            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}