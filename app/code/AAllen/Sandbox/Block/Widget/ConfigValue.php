<?php

namespace AAllen\Sandbox\Block\Widget;


use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class ConfigValue extends Template implements BlockInterface
{
    protected $_scopeConfig;

    public function __construct(
        Template\Context $context,
        array $data
    )
    {
        parent::__construct($context, $data);

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