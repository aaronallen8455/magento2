<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 9/20/2016
 * Time: 3:25 PM
 */

namespace AAllen\FilterStates\Plugin;


class StateFilter
{
    protected $disallowed = [
        'Guam',
        'Puerto Rico',
        'Palau',
        'Virgin Islands',
        'Northern Mariana Islands',
        'Marshall Islands',
        'Federated States Of Micronesia',
        'American Samoa',
        'Armed Forces Africa',
        'Armed Forces Americas',
        'Armed Forces Canada',
        'Armed Forces Europe',
        'Armed Forces Middle East',
        'Armed Forces Pacific',
        'Hawaii',
        'Alaska'
    ];

    public function afterToOptionArray($subject, $options)
    {
        $result = array_filter($options, function ($option) {
            if (isset($option['label']))
                return !in_array($option['label'], $this->disallowed);
            return true;
        });

        return $result;
    }
}