<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 9/1/2016
 * Time: 5:25 AM
 */

namespace AAllen\PageTitleSuffix\Plugin;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Page\Title;
use Magento\Store\Model\Information;

class Config
{
    protected $_scopeConfig;
    protected $count;
    protected $storeName;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->_scopeConfig = $scopeConfig;
        $this->count = 0;
    }

    public function afterGetTitle($subject, Title $title)
    {
        $this->count++;

        if (!isset($this->storeName)) {
            $this->storeName = $this->_scopeConfig->getValue(Information::XML_PATH_STORE_INFO_NAME);
        }

        $pageTitle = $title->get();
        if ($this->count === 2) {
            $title->set($pageTitle . ' - ' . $this->storeName);
            //$this->flag = true;
        } else if ($this->count === 3) {
            $title->set(str_replace(' - ' . $this->storeName, '', $pageTitle));
        }

        return $title;
    }
}