<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/7/2016
 * Time: 4:36 PM
 */

namespace AAllen\Showcase\Block\Adminhtml\Form\Field;


use Magento\Backend\Block\Template;



class Tabs extends Template
{

    public function getElement()
    {
        return $this->_getData('element');
    }

    public function getElementValue()
    {
        return $this->getElement()->getEscapedValue();
    }

}