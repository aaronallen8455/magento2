<?php

namespace AAllen\Test\Controller;


use Magento\Framework\App\Router\NoRouteHandlerInterface;

class NoRouteHandler implements NoRouteHandlerInterface
{
    public function process(\Magento\Framework\App\RequestInterface $request)
    {
        $request->setModuleName('404')->setControllerName('redirect')->setActionName('index');
    }
}