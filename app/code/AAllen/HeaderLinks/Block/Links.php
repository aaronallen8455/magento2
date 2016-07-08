<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/6/2016
 * Time: 6:33 PM
 */

namespace AAllen\HeaderLinks\Block;


use Magento\Customer\Model\Url;
use Magento\Framework\App\Http\Context;
use Magento\Framework\View\Element\Template;

class Links extends Template
{
    /** @var Url $_customerUrl */
    protected $_customerUrl;
    
    /** @var Context $httpContext */
    protected $httpContext;

    /**
     * Links constructor.
     * @param Template\Context $context
     * @param array $data
     * @param Url $customerUrl
     * @param Context $httpContext
     */
    public function __construct(Template\Context $context,
                                Url $customerUrl,
                                Context $httpContext,
                                array $data)
    {
        $this->_customerUrl = $customerUrl;
        $this->httpContext = $httpContext;
        
        parent::__construct($context, $data);
    }

    /**
     * Is logged in
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    /**
     * Get account URL
     *
     * @return string
     */
    public function getAccountUrl()
    {
        return $this->_customerUrl->getAccountUrl();
    }

    /**
     * Get login link href
     * 
     * @return string
     */
    public function getLoginHref()
    {
        return $this->isLoggedIn()
            ? $this->_customerUrl->getLogoutUrl()
            : $this->_customerUrl->getLoginUrl();
    }

    /**
     * Get login link text
     *
     * @return string
     */
    public function getLoginText()
    {
        return $this->isLoggedIn()
            ? 'Log out'
            : 'Log in';
    }

    /**
     * Get registration link href
     * 
     * @return string
     */
    public function getRegisterHref()
    {
        return $this->_customerUrl->getRegisterUrl();
    }
}