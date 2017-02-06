<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/5/2017
 * Time: 10:59 PM
 */

namespace AAllen\Images\Block\Images;



use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\Factory;

class Selector extends AbstractFieldArray
{
    protected $elementFactory;

    protected $_template = 'AAllen_Images::array.phtml';

    public function __construct(Context $context, Factory $elementFactory, array $data = [])
    {
        $this->elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_addButtonLabel = 'Add Image';
        parent::_construct();
    }

    /**
     * Prepare to render
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'image',
            [
                'label'     => __('Image'),
                'size'  => '15',
            ]
        );
        $this->_addAfter = false;
    }

    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {

        $element->setData('after_element_html', $this->getLayout()->createBlock('AAllen\UspsCustomRates\Block\Adminhtml\Form\Field\CustomRates')->toHtml());

        return $element;
    }
}