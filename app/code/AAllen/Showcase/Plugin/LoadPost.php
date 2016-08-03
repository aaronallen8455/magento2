<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/3/2016
 * Time: 3:57 AM
 */

namespace AAllen\Showcase\Plugin;


class LoadPost
{
    public function aroundLoadPost($subject, \Closure $proceed, array $data, $group)
    {
        $arr = $subject->_convertFlatToRecursive($data);
        if (isset($arr[$group])) {
            $subject->getConditions()->setConditions([])->loadArray($arr[$group][1]);
        }
        if (isset($arr['actions'])) {
            $subject->getActions()->setActions([])->loadArray($arr['actions'][1], 'actions');
        }

        return $subject;
    }

}