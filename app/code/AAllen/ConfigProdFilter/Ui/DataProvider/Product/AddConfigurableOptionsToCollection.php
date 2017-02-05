<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 1/3/2017
 * Time: 12:16 AM
 */

namespace AAllen\ConfigProdFilter\Ui\DataProvider\Product;


use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;

class AddConfigurableOptionsToCollection implements AddFilterToCollectionInterface
{
    protected $configurableOptions = null;

    public function __construct(\Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable\Attribute\Collection $collection)
    {
        $this->configurableOptions = $collection;
    }

    public function addFilter(Collection $collection, $field, $condition = null)
    {
        if (isset($condition['eq']) && ($numberOfOptions = $condition['eq'])) {

            $select = $this->configurableOptions->getSelect()
                ->reset(\Zend_Db_Select::COLUMNS)
                ->columns(array('product_id', 'COUNT(*) as cnt'))
                ->group('product_id');
                //->where('cnt = ?', $numberOfOptions);

            $res = $this->configurableOptions->getConnection()->fetchAll($select);

            $ids = array();
            foreach ($res as $opt) {
                if ($opt['cnt'] == $numberOfOptions) {
                    $ids[] = $opt['product_id'];
                }
            }

            $collection->addFieldToFilter('entity_id', array('in' => $ids));
        }
    }
}