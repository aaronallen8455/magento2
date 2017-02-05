<?php

namespace AAllen\AddToCartButton\Controller\Cart;


class Add extends \Magento\Checkout\Controller\Cart\Add
{
    public function execute()
    {
        $this->getRequest()->setParams(
            ['return_url' => $this->_objectManager->get('Magento\Checkout\Helper\Cart')->getCartUrl()]
        );

        return parent::execute();
    }
}