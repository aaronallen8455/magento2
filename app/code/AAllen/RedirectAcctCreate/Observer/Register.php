<?php

namespace AAllen\RedirectAcctCreate\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;

class Register implements ObserverInterface
{
    protected $coreRegistry;

    public function __construct(Registry $registry)
    {
        $this->coreRegistry = $registry;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->coreRegistry->register('is_new_account', true);
    }
}