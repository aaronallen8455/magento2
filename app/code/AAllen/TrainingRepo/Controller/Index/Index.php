<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 1/1/2017
 * Time: 11:33 PM
 */

namespace AAllen\TrainingRepo\Controller\Index;


use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Symfony\Component\DependencyInjection\Tests\Compiler\F;

class Index extends Action
{
    protected $customerRepo;

    protected $searchCriteriaBuilder;

    protected $filterBuilder;

    protected $filterGroupBuilder;

    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder
    ) {
        $this->customerRepo = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;

        parent::__construct($context);
    }

    public function execute()
    {
        $this->getResponse()->setHeader('content-type', 'text/plain');

        $customers = $this->getCustomersFromRepository();

        $this->getResponse()->appendBody(
            sprintf("List contains %s\n\n", get_class($customers[0]))
        );

        foreach ($customers as $customer) {
            $this->outputCustomer($customer);
        }
    }

    private function getCustomersFromRepository()
    {
        $this->addOrFilter();
        $this->addAndFilter();

        $criteria = $this->searchCriteriaBuilder->create();
        $customers = $this->customerRepo->getList($criteria);
        return $customers->getItems();
    }

    private function outputCustomer(CustomerInterface $customer)
    {
        $this->getResponse()->appendBody(
            sprintf(
                "\"%s %s\" <%s> (%s)\n",
                $customer->getFirstname(),
                $customer->getLastname(),
                $customer->getEmail(),
                $customer->getId()
            )
        );
    }

    private function addOrFilter()
    {
        $nameFilter = $this->filterBuilder
            ->setField('firstname')
            ->setValue('Hans')
            ->setConditionType('eq')
            ->create();
        $this->filterGroupBuilder->addFilter($nameFilter);

        $emailFilter = $this->filterBuilder
            ->setField('email')
            ->setValue('%@dmail.com')
            ->setConditionType('like')
            ->create();
        $this->filterGroupBuilder->addFilter($emailFilter);

        $this->searchCriteriaBuilder->setFilterGroups(
            [$this->filterGroupBuilder->create()]
        );
    }

    private function addAndFilter()
    {
        $idFilter = $this->filterBuilder
            ->setField('id')
            ->setValue(0)
            ->setConditionType('eq')
            ->create();

        $this->searchCriteriaBuilder->addFilters([$idFilter]);
    }
}