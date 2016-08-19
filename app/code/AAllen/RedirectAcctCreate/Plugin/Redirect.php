<?php

namespace AAllen\RedirectAcctCreate\Plugin;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

class Redirect
{
    protected $coreRegistry;

    protected $url;

    protected $resultFactory;

    public function __construct(Registry $registry, UrlInterface $url, ResultFactory $resultFactory)
    {
        $this->coreRegistry = $registry;
        $this->url = $url;
        $this->resultFactory = $resultFactory;
    }

    public function aroundGetRedirect ($subject, \Closure $proceed)
    {
        if ($this->coreRegistry->registry('is_new_account')) {
            /** @var \Magento\Framework\Controller\Result\Redirect $result */
            $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $result->setUrl($this->url->getUrl('sandbox/box'));
            return $result;
        }

        return $proceed();
    }
}