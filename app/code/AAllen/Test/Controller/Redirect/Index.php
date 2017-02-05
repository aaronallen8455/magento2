<?php

namespace AAllen\Test\Controller\Redirect;


use Magento\Framework\App\Action\Action;

class Index extends Action
{
    public function execute()
    {
        $this->_redirect('404');
    }
}