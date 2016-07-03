<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/2/2016
 * Time: 3:16 AM
 */

namespace AAllen\Sandbox\Block;


use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Block extends Template
{
    protected $_passedData;

    public function __construct(Context $context, array $data)
    {
        $this->_passedData = $data;
        parent::__construct($context, $data);
    }

    public function printData()
    {
        return print_r(current($this->_data), true);
    }
}