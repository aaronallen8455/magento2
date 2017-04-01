<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/21/2017
 * Time: 6:17 PM
 */

namespace AAllen\TrackingLink\Controller\Index;


use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Shipping\Controller\Tracking\Popup;

class Index extends Popup
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Shipping\Model\InfoFactory $shippingInfoFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        PageFactory $pageFactory
    ) {
        $this->resultPageFactory = $pageFactory;

        parent::__construct($context, $coreRegistry, $shippingInfoFactory, $orderFactory);
    }

    /**
     * Shows tracking info if it's present, otherwise redirects to 404
     *
     * @throws NotFoundException
     */
    public function execute()
    {
        $shippingInfoModel = $this->_shippingInfoFactory->create()->loadByHash($this->getRequest()->getParam('hash'));
        $this->_coreRegistry->register('current_shipping_info', $shippingInfoModel);
        if (count($shippingInfoModel->getTrackingInfo()) == 0) {
            throw new NotFoundException(__('Page not found.'));
        }

        return $this->resultPageFactory->create();
    }
}