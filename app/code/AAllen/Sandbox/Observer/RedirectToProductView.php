<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 12/27/2016
 * Time: 10:14 PM
 */

namespace AAllen\Sandbox\Observer;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class RedirectToProductView implements ObserverInterface
{
    protected $redirect;

    protected $_actionFlag;

    protected $_logger;

    public function __construct(
        RedirectInterface $redirect,
        ActionFlag $actionFlag,
        LoggerInterface $logger
    ) {
        $this->redirect = $redirect;
        $this->_actionFlag = $actionFlag;
        $this->_logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        ///** @var RequestInterface $request */
        //$request = $observer->getEvent()->getData('request');
        //if ($request->getModuleName() != 'catalog' || $request->getControllerName() != 'product') {
        //    $controller = $observer->getControllerAction();
        //    $this->_actionFlag->set('', Action::FLAG_NO_DISPATCH, true);
        //    $this->redirect->redirect($controller->getResponse(), 'catalog/product/view/id/1');
        //}
        $this->_logger->debug('one');
    }
}