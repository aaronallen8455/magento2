<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/30/2017
 * Time: 8:45 PM
 */

namespace AAllen\CheckoutCheckbox\Plugin;


use AAllen\CheckoutCheckbox\Model\Total\GiftWrap;
use Magento\Quote\Model\Quote;

class GiftwrapPlug
{
    protected $quoteRepository;

    public function __construct(\Magento\Quote\Api\CartRepositoryInterface $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function aroundGet($subject, callable $proceed, $cartId)
    {
        $quoteTotals = $proceed($cartId);

        /** @var Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        if ($quote->getIsGiftWrapped() === 'true') {
            $quoteTotals->setGiftwrap(GiftWrap::GIFTWRAP_COST);
        }
        else {
            $quoteTotals->setGiftwrap(15);
        }

        return $quoteTotals;
    }
}