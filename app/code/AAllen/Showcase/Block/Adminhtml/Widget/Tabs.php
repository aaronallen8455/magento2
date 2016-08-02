<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/31/2016
 * Time: 11:15 PM
 */

namespace AAllen\Showcase\Block\Adminhtml\Widget;


use Magento\Backend\Block\Widget;
use Magento\Framework\View\Element\Text;
use Magento\Widget\Block\BlockInterface;

class Tabs extends Widget
{

    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $uniqId = $this->mathRandom->getUniqueHash($element->getId());
        //$sourceUrl = $this->getUrl('cms/page_widget/chooser', ['uniq_id' => $uniqId]);

        //$chooser = $this->getLayout()->createBlock(
        //    'Magento\Widget\Block\Adminhtml\Widget\Chooser'
        //)->setElement(
        //    $element
        //)->setConfig(
        //    $this->getConfig()
        //)->setFieldsetId(
        //    $this->getFieldsetId()
        //)->setSourceUrl(
        //    $sourceUrl
        //)->setUniqId(
        //    $uniqId
        //);

        //if ($element->getValue()) {
        //    $page = $this->_pageFactory->create()->load((int)$element->getValue());
        //    if ($page->getId()) {
        //        $chooser->setLabel($this->escapeHtml($page->getTitle()));
        //    }
        //}

        $text = $this->getLayout()->createBlock(
            'AAllen\Showcase\Block\Adminhtml\Form\Field\Tabs'
        )->setTemplate(
            'AAllen_Showcase::tabs.phtml'
        )->setElement(
            $element
        );

        $element->setData('after_element_html', $text->toHtml());
        return $element;
    }

}