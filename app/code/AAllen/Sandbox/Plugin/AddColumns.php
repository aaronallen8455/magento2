<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 10/10/2017
 * Time: 6:19 PM
 */

namespace AAllen\Sandbox\Plugin;

class AddColumns
{
    public function aroundGetReport($subject, callable $proceed, $requestName) {
        /** @var \Magento\Framework\Data\Collection $result */
        $result = $proceed($requestName);

        if ($requestName === "sales_order_grid_data_source") {
            $select = $result->getSelect();

            $select->join(
                ["soi" => "sales_order_item"],
                'main_table.entity_id = soi.order_id AND soi.product_type="simple"',
                array('weight', 'product_type')
            );

            $select->join(
                ["soa" => "sales_order_address"],
                'main_table.entity_id = soa.parent_id AND soa.address_type="shipping"',
                array('email','company' ,'country_id', 'postcode', 'city', 'telephone')
            );
        }

        return $result;
    }
}