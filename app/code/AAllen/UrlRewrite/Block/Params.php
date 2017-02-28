<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/21/2017
 * Time: 12:58 AM
 */

namespace AAllen\UrlRewrite\Block;


use Magento\Framework\View\Element\Template;

class Params extends Template
{
    protected $_template = 'AAllen_UrlRewrite::params.phtml';

    public function getParam()
    {
        $request = $this->getRequest();

        return $request->getParam('background');
    }
}