<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/17/2017
 * Time: 10:30 PM
 */

namespace AAllen\Sandbox\Plugin;


use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Email\Container\Template;

class ShipEmailPlug
{

    public function beforeSetTemplateVars(Template $subject, array $vars) {
        /** @var Order $order */
        $order = $vars['order'];
        $method = $order->getShippingMethod();

        $vars['is_pickup'] = $method === 'flatrate_flatrate';

        return [$vars];
    }
}