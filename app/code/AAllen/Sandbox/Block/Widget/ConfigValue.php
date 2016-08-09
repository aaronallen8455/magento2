<?php

namespace AAllen\Sandbox\Block\Widget;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class ConfigValue extends Template implements BlockInterface
{
    protected $_scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data
    )
    {
        parent::__construct($context, $data);

        $this->_scopeConfig = $scopeConfig;
        $this->setTemplate('AAllen_Sandbox::configvalue.phtml');
    }

    public function getValue()
    {
        $path = $this->getData('xml_path');

        return $this->_scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}