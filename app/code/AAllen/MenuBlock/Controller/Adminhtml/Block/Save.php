<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/23/2016
 * Time: 1:11 AM
 */

namespace AAllen\MenuBlock\Controller\Adminhtml\Block;


use AAllen\MenuBlock\Api\BlockRepositoryInterface;
use AAllen\MenuBlock\Model\Block;
use AAllen\MenuBlock\Model\BlockFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    /** @var BlockFactory $_blockFactory */
    protected $_blockFactory;

    /** @var  BlockRepositoryInterface $_blockRepository */
    protected $_blockRepository;

    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context, BlockFactory $blockFactory, BlockRepositoryInterface $blockRepository)
    {
        $this->_blockFactory = $blockFactory;
        $this->_blockRepository = $blockRepository;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('AAllen_MenuBlock::save');
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var Block $model */
            $model = $this->_blockFactory->create();

            $id = $this->getRequest()->getParam('block_id');
            if ($id) {
                $model = $this->_blockRepository->getById($id);
            }else{
                unset($data['block_id']);
            }

            //check for empty child block id
            if ($data['child_block_id'] == '') $data['child_block_id'] = null;
            //nullify empty width
            if ($data['width'] == '' || $data['width'] === '0') $data['width'] = null;

            $model->setData($data);

            $this->_eventManager->dispatch(
                'menublock_block_prepare_save',
                ['block' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->_blockRepository->save($model);
                //$model->save();
                $this->messageManager->addSuccess(__('You saved this Block.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['block_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, $e->getMessage());
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['block_id' => $this->getRequest()->getParam('block_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}