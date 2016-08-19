<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AAllen\CustomContactUs\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;

/**
 * Main contact form block
 */
class ContactForm extends \Magento\Contact\Block\ContactForm
{
    /** @var  Session $session */
    protected $session;

    public function __construct(Template\Context $context, Session $session, array $data)
    {
        parent::__construct($context, $data);

        $this->session = $session;
    }

    /**
     * Check if customer is logged in
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->session->isLoggedIn();
    }

    /**
     * Get customer's email
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->session->getCustomer()->getEmail();
    }

    /**
     * Get customer's name
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->session->getCustomer()->getName();
    }
}
