<?php

namespace AAllen\Faq\Api;

use AAllen\Faq\Api\Data\FaqInterface;

/**
 * CMS block CRUD interface.
 * @api
 */
interface FaqRepositoryInterface
{
    /**
     * Save faq.
     *
     * @param FaqInterface $faq
     * @return FaqInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(FaqInterface $faq);

    /**
     * Retrieve Faq.
     *
     * @param int $faqId
     * @return FaqInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($faqId);

    /**
     * Delete faq.
     *
     * @param FaqInterface $faq
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(FaqInterface $faq);

    /**
     * Delete faq by ID.
     *
     * @param int $faqId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($faqId);
}
