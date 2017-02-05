<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 1/14/2017
 * Time: 3:22 PM
 */

namespace AAllen\Test\Controller;


use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Router\DefaultRouter;

class Router extends DefaultRouter
{
    public function match(RequestInterface $request)
    {
        $request->setModuleName('test');
        $request->setControllerName('index');
        $request->setActionName('index');

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}