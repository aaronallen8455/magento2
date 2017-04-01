<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/28/2017
 * Time: 9:18 PM
 */

namespace AAllen\CheckoutCheckbox\Api;

/**
 * Coupon management service interface.
 * @api
 */
interface GiftwrapManagementInterface
{
    /**
     * Returns information for a coupon in a specified cart.
     *
     * @param string $cartId The cart ID.
     * @return string The coupon code data.
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     */
    public function get($cartId);

    /**
     * Adds a coupon by code to a specified cart.
     *
     * @param string $cartId The cart ID.
     * @param string $giftwrap The coupon code data.
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException The specified cart does not exist.
     * @throws \Magento\Framework\Exception\CouldNotSaveException The specified coupon could not be added.
     */
    public function set($cartId, $giftwrap);
}