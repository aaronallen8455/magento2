<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AAllen\Sandbox\Model\Account;

use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Redirect as ResultRedirect;
use Magento\Framework\Controller\Result\Forward as ResultForward;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Stdlib\CookieManagerInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Redirect extends \Magento\Customer\Model\Account\Redirect
{
    protected $_coreRegistry;

    public function __construct(
        RequestInterface $request,
        Session $customerSession,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
        DecoderInterface $urlDecoder,
        CustomerUrl $customerUrl,
        ResultFactory $resultFactory,
        Registry $registry
    )
    {
        $this->_coreRegistry = $registry;

        parent::__construct($request, $customerSession, $scopeConfig, $storeManager, $url, $urlDecoder, $customerUrl, $resultFactory);
    }

    /**
     * Prepare redirect URL for logged in customer
     *
     * Redirect customer to the last page visited after logging in.
     *
     * @return void
     */
    protected function processLoggedCustomer()
    {
        // Set default redirect URL for logged in customer
        if (!empty($this->_coreRegistry->registry('is_new_account'))) {
            $this->applyRedirect($this->url->getUrl('sandbox/box'));
        }
        $this->applyRedirect($this->customerUrl->getAccountUrl());


        if (!$this->scopeConfig->isSetFlag(
            CustomerUrl::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD,
            ScopeInterface::SCOPE_STORE
        )
        ) {
            $referer = $this->request->getParam(CustomerUrl::REFERER_QUERY_PARAM_NAME);
            if ($referer) {
                $referer = $this->urlDecoder->decode($referer);
                if ($this->url->isOwnOriginUrl()) {
                    $this->applyRedirect($referer);
                }
            }
        } elseif ($this->session->getAfterAuthUrl()) {
            $this->applyRedirect($this->session->getAfterAuthUrl(true));
        }
    }

    /**
     * Prepare redirect URL
     *
     * @param string $url
     * @return void
     */
    private function applyRedirect($url)
    {
        $this->session->setBeforeAuthUrl($url);
    }
}
