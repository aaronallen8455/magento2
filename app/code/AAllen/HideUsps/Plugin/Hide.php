<?php

namespace AAllen\HideUsps\Plugin;


use Magento\Backend\Model\Auth\Session;

class Hide
{
    protected $backendSession;

    public function __construct(Session $session)
    {
        $this->backendSession = $session;
    }

    public function aroundCanCollectRates($subject, callable $proceed)
    {
        if ($this->backendSession->isLoggedIn()) {
            return $proceed();
        }

        return false;
    }
}