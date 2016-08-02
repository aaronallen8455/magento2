<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/2/2016
 * Time: 2:22 AM
 */

namespace AAllen\Showcase\Plugin;


class FormPlugin
{

    public function aroundCheckElementId()
    {
        return true;
    }
}