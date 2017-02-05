<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 1/3/2017
 * Time: 12:01 AM
 */

namespace AAllen\ConfigProdFilter\Ui\Component\Listing;


use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{
    protected $options;

    public function toOptionArray()
    {
        if ($this->options) return $this->options;

        $this->options = array(
            array(
                'label' => ' ',
                'value' => 0
            ),
            array(
                'label' => 'One',
                'value' => 1
            ),
            array(
                'label' => 'Two',
                'value' => 2
            ),
            array(
                'label' => 'Three',
                'value' => 3
            ),

        );

        return $this->options;
    }
}