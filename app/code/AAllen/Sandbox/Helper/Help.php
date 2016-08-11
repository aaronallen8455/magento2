<?php

namespace Your\Module\Helper;


use Magento\Framework\App\Helper\AbstractHelper;

class Help extends AbstractHelper
{

    function stringFunc($string)
    {
        return $string . ' helped';
    }

}