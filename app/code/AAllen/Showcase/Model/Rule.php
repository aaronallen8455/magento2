<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/3/2016
 * Time: 4:10 AM
 */

namespace AAllen\Showcase\Model;


/**
 * Class Rule
 */
class Rule extends \Magento\CatalogWidget\Model\Rule
{
    public function loadPost(array $data)
    {
        $arr = $this->_convertFlatToRecursive($data);
        if (isset($arr['aaron'])) {
            $this->getConditions()->setConditions([])->loadArray($arr['aaron'][1]);
        }
        if (isset($arr['actions'])) {
            $this->getActions()->setActions([])->loadArray($arr['actions'][1], 'actions');
        }

        return $this;
    }
}