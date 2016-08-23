<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/21/2016
 * Time: 1:48 PM
 */

namespace AAllen\AddButtonToProdList;


use Magento\Framework\View\Element\Template;

class Buttons extends Template
{

    public function renderChildren()
    {
        $this->getChildNames();
    }
}