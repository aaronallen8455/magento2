<?php


namespace AAllen\ProductTabs\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use AAllen\ProductTabs\Model\ResourceModel\Tab as ResourceTab;
use AAllen\ProductTabs\Model\ResourceModel\Tab\CollectionFactory as TabCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use AAllen\ProductTabs\Api\Data\TabInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use AAllen\ProductTabs\Api\Data\TabSearchResultsInterfaceFactory;
use AAllen\ProductTabs\Api\TabRepositoryInterface;

class TabRepository implements tabRepositoryInterface
{

    private $storeManager;

    protected $searchResultsFactory;

    protected $dataTabFactory;

    protected $dataObjectProcessor;

    protected $tabCollectionFactory;

    protected $dataObjectHelper;

    protected $resource;

    protected $tabFactory;


    /**
     * @param ResourceTab $resource
     * @param TabFactory $tabFactory
     * @param TabInterfaceFactory $dataTabFactory
     * @param TabCollectionFactory $tabCollectionFactory
     * @param TabSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceTab $resource,
        TabFactory $tabFactory,
        TabInterfaceFactory $dataTabFactory,
        TabCollectionFactory $tabCollectionFactory,
        TabSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->tabFactory = $tabFactory;
        $this->tabCollectionFactory = $tabCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTabFactory = $dataTabFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \AAllen\ProductTabs\Api\Data\TabInterface $tab
    ) {
        /* if (empty($tab->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $tab->setStoreId($storeId);
        } */
        try {
            $tab->getResource()->save($tab);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the tab: %1',
                $exception->getMessage()
            ));
        }
        return $tab;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($tabId)
    {
        $tab = $this->tabFactory->create();
        $tab->getResource()->load($tab, $tabId);
        if (!$tab->getId()) {
            throw new NoSuchEntityException(__('Tab with id "%1" does not exist.', $tabId));
        }
        return $tab;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->tabCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \AAllen\ProductTabs\Api\Data\TabInterface $tab
    ) {
        try {
            $tab->getResource()->delete($tab);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Tab: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($tabId)
    {
        return $this->delete($this->getById($tabId));
    }
}
