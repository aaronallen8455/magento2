<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/7/2016
 * Time: 4:36 PM
 */

namespace AAllen\UspsCustomRates\Block\Adminhtml\Form\Field;


use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;


class CustomRates extends AbstractFieldArray
{
    /**
     * @var Methods
     */
    protected $methodRenderer = null;

    /**
     * @var string
     */
    protected $_template = 'AAllen_UspsCustomRates::system/config/form/field/array.phtml';
    
    protected function _construct()
    {
        $this->_addButtonLabel = 'Add Rule';
        parent::_construct(); // TODO: Change the autogenerated stub
    }

    /**
     * Returns renderer for methods element
     *
     * @return Methods
     */
    protected function getMethodRenderer()
    {
        if (!$this->methodRenderer) {
            $this->methodRenderer = $this->getLayout()->createBlock(
                Methods::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->methodRenderer;
    }

    /**
     * Prepare to render
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'method_code',
            [
                'label'     => __('Method'),
                'renderer'  => $this->getMethodRenderer(),
            ]
        );
        $this->addColumn(
            'price',
            [
                'label' => __('Price'),
                'size'  => '15',
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Rule');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $method = $row->getMethodCode();
        $options = [];
        if ($method) {
            $options['option_' . $this->getMethodRenderer()->calcOptionHash($method)]
                = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
}