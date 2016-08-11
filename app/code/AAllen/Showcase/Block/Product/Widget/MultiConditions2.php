<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Product Chooser for "Product Link" Cms Widget Plugin
 */
namespace AAllen\Showcase\Block\Product\Widget;

use Magento\Backend\Block\Template;
use Magento\CatalogWidget\Block\Product\Widget\Conditions;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\CatalogWidget\Model\Rule\Condition\ProductFactory;

/**
 * Class MultiConditions
 */
class MultiConditions2 extends \AAllen\Showcase\Block\Product\Widget\Conditions2 implements RendererInterface
{

    public function __construct(
        Template\Context $context,
        \Magento\Framework\Data\Form\Element\Factory $elementFactory,
        \Magento\Rule\Block\Conditions $conditions, // *
        \AAllen\Showcase\Model\Rule2 $rule,
        \Magento\Framework\Registry $registry,
        array $data = [])
    {

        parent::__construct($context, $elementFactory, $conditions, $rule, $registry, $data);

    }
}
