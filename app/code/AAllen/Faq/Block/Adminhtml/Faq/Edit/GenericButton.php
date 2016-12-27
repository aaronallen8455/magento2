<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AAllen\Faq\Block\Adminhtml\Faq\Edit;

use AAllen\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var FaqRepositoryInterface
     */
    protected $faqRepository;

    /**
     * @param Context $context
     * @param FaqRepositoryInterface $faqRepository
     */
    public function __construct(
        Context $context,
        FaqRepositoryInterface $faqRepository
    ) {
        $this->context = $context;
        $this->faqRepository = $faqRepository;
    }

    /**
     * Return Faq ID
     *
     * @return int|null
     */
    public function getBlockId()
    {
        try {
            return $this->faqRepository->getById(
                $this->context->getRequest()->getParam('faq_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
