<?php

/**
 * Product Chooser for "Product Link" Cms Widget Plugin
 */
namespace AAllen\Showcase\Block\Product\Widget;

use Magento\Backend\Block\Template;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\CatalogWidget\Model\Rule\Condition\ProductFactory;

/**
 * Class MultiConditions
 */
class MultiConditions5 extends \AAllen\Showcase\Block\Product\Widget\Conditions5 implements RendererInterface
{

    public function __construct(
        Template\Context $context,
        \Magento\Framework\Data\Form\Element\Factory $elementFactory,
        \Magento\Rule\Block\Conditions $conditions, // *
        \AAllen\Showcase\Model\Rule5 $rule,
        \Magento\Framework\Registry $registry,
        array $data = [])
    {

        parent::__construct($context, $elementFactory, $conditions, $rule, $registry, $data);

    }
}
