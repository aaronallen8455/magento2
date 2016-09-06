<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AAllen\Faq\Controller\Adminhtml\Question;

use AAllen\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action\Context;
use AAllen\Faq\Model\Faq;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \AAllen\Faq\Controller\Adminhtml\Faq
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var FaqRepositoryInterface
     */
    protected $faqRepo;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        FaqRepositoryInterface $faqRepository
    ) {
        $this->faqRepo = $faqRepository;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('faq_id');

            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Faq::STATUS_ENABLED;
            }
            if (empty($data['faq_id'])) {
                $data['faq_id'] = null;
            }

            /** @var Faq $model */
            $model = $this->_objectManager->create('AAllen\Faq\Model\Faq')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This question no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $this->faqRepo->save($model);
                $this->messageManager->addSuccess(__('You saved the question.'));
                $this->dataPersistor->clear('faq_question');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['faq_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the question.'));
            }

            $this->dataPersistor->set('faq_question', $data);
            return $resultRedirect->setPath('*/*/edit', ['faq_id' => $this->getRequest()->getParam('faq_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
