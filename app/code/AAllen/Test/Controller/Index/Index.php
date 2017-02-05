<?php

namespace AAllen\Test\Controller\Index;


use Magento\Framework\App\Action\Action;

class Index extends Action
{
    public function execute()
    {
        $this->_forward('index', 'noroute', 'cms');
    }
}