<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/12/2017
 * Time: 5:08 AM
 */

namespace AAllen\FixThirdCat\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class CheckUrl
{
    protected $message;
    protected $request;
    protected $urlCoder;

    public function __construct(MessageManagerInterface $manager, RequestInterface $request, \Magento\Framework\Encryption\UrlCoder $urlCoder)
    {
        $this->request = $request;
        $this->message = $manager;
        $this->urlCoder = $urlCoder;
    }

    public function afterGetRedirectUrl(\Magento\Store\App\Response\Redirect $subject, $url)
    {
        //$u = $this->urlCoder->encode('http://192.168.33.33/men/tops-men/jackets-men/proteus-fitness-jackshirt.html');

        $u = $this->request->getRequestUri();

        $this->message->addErrorMessage($this->request->getParam(\Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED) . ' ' . $u);

        return $url;
    }
}