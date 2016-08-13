<?php


/**
 * CatalogWidget Rule Combine Condition data model
 */
namespace AAllen\Showcase\Model\Rule\Condition\Combine;

class Combine5 extends \AAllen\Showcase\Model\Rule\Condition\Combine5
{
    /**
     * @var \Magento\CatalogWidget\Model\Rule\Condition\ProductFactory
     */
    protected $productFactory;

    /**
     * {@inheritdoc}
     */
    protected $elementName = 'parameters';

    /**
     * @param \Magento\Rule\Model\Condition\Context $context
     * @param \Magento\CatalogWidget\Model\Rule\Condition\ProductFactory $conditionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Magento\CatalogWidget\Model\Rule\Condition\ProductFactory $conditionFactory,
        array $data = []
    ) {
        $this->productFactory = $conditionFactory;
        parent::__construct($context, $data);
        $this->setType('AAllen\Showcase\Model\Rule\Condition\Combine\Combine5');
    }

    /**
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $productAttributes = $this->productFactory->create()->loadAttributeOptions()->getAttributeOption();
        $attributes = [];
        foreach ($productAttributes as $code => $label) {
            $attributes[] = [
                'value' => 'Magento\CatalogWidget\Model\Rule\Condition\Product|' . $code,
                'label' => $label,
            ];
        }
        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive(
            $conditions,
            [
                [
                    'value' => 'AAllen\Showcase\Model\Rule\Condition\Combine\Combine5',
                    'label' => __('Conditions Combination'),
                ],
                ['label' => __('Product Attribute'), 'value' => $attributes]
            ]
        );
        return $conditions;
    }

    /**
     * Collect validated attributes for Product Collection
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @return $this
     */
    public function collectValidatedAttributes($productCollection)
    {
        foreach ($this->getConditions() as $condition) {
            $condition->addToCollection($productCollection);
        }
        return $this;
    }
}
