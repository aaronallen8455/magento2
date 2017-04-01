<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/28/2017
 * Time: 9:20 PM
 */

namespace AAllen\CheckoutCheckbox\Model;


use AAllen\CheckoutCheckbox\Api\GiftwrapManagementInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CouponManagementInterface;
use Magento\Quote\Model\QuoteIdMask;
use Magento\Quote\Model\QuoteIdMaskFactory;

class GiftwrapManagement implements GiftwrapManagementInterface
{
    /**
     * Quote repository.
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    protected $quoteIdMaskFactory;

    protected $couponManagement;

    /**
     * Constructs a coupon read service object.
     *
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository Quote repository.
     */
    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository, QuoteIdMaskFactory $quoteIdMaskFactory, CouponManagementInterface $couponManagement
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->couponManagement = $couponManagement;
    }

    /**
     * {@inheritdoc}
     */
    public function set($cartId, $isGiftwrapped)
    {

        /** @var QuoteIdMask $quoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        $quoteId = $quoteIdMask->getQuoteId();
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($quoteId);
        if (!$quote->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
        }
        $quote->getShippingAddress()->setCollectShippingRates(true);

        try {
            $quote->setIsGiftwrapped($isGiftwrapped === 'true');
            $this->quoteRepository->save($quote->collectTotals());
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not apply coupon code'));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get($cartId)
    {
        /** @var QuoteIdMask $quoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        /** @var  \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($quoteIdMask->getMaskedId());
        return $quote->getIsGiftwrapped();
    }
}