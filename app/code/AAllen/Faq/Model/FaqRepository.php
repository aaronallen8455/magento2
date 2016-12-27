<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 9/5/2016
 * Time: 10:07 PM
 */

namespace AAllen\Faq\Model;


use AAllen\Faq\Api\FaqRepositoryInterface;
use AAllen\Faq\Model\ResourceModel\Faq as FaqResource;
use Magento\Store\Model\StoreManagerInterface;

class FaqRepository implements FaqRepositoryInterface
{
    /** @var StoreManagerInterface $storeManager */
    protected $storeManager;

    /** @var Faq $resource */
    protected $resource;

    /** @var FaqFactory $faqFactory */
    protected $faqFactory;

    /**
     * FaqRepository constructor.
     * @param StoreManagerInterface $storeManager
     * @param Faq $resource
     * @param FaqFactory $faqFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        FaqResource $resource,
        \AAllen\Faq\Model\FaqFactory $faqFactory
    ){
        $this->storeManager = $storeManager;
        $this->resource = $resource;
        $this->faqFactory = $faqFactory;
    }

    /**
     * Save faq data
     *
     * @param \AAllen\Faq\Api\Data\FaqInterface $faq
     * @return \AAllen\Faq\Model\Faq
     * @internal param \AAllen\MenuBlock\Api\Data\BlockInterface $block
     */
    public function save(\AAllen\Faq\Api\Data\FaqInterface $faq)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $faq->setStoreId($storeId);
        try {
            $this->resource->save($faq);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $faq;
    }

    /**
     * Load faq data by given Block Identity
     *
     * @param string $faqId
     * @return \AAllen\Faq\Model\Faq
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($faqId)
    {
        $faq = $this->faqFactory->create();
        $this->resource->load($faq, $faqId);
        if (!$faq->getId()) {
            throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $faqId));
        }
        return $faq;
    }

    /**
     * Delete Block
     *
     * @param \AAllen\Faq\Api\Data\FaqInterface $faq
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\AAllen\Faq\Api\Data\FaqInterface $faq)
    {
        try {
            $this->resource->delete($faq);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Block by given Block Identity
     *
     * @param string $faqId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($faqId)
    {
        return $this->delete($this->getById($faqId));
    }
}