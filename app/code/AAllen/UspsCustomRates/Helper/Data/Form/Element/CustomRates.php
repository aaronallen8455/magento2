<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Form select element
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace AAllen\UspsCustomRates\Helper\Data\Form\Element;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Multiselect;

class CustomRates extends AbstractElement
{
    /**
     * Get the element as HTML
     *
     * @return string
     */
    public function getElementHtml()
    {
        $this->addClass('select multiselect admin__control-multiselect');
        $html = '';
        
        // this input holds the complete value string
        $html .= '<input type="hidden" name="' . parent::getName() . '" value="' . $this->getValue() . '" id="customRatesValue" />';

        // the saved result string
        $value = $this->getValue();
        
        // add rule button
        $html .= '<button id="addRule" type="button">Add Rule</button>';
        
        // contains the rules
        $html .= '<div id="custom_rates">' . "\n";
        
        // list of methods
        $values = urlencode(json_encode($this->getValues()));

        $html .= '</div>' . "\n";

        $html .= $this->getJs($values, $value) . "\n";

        return $html;
    }

    /**
     * Get JS for rate select
     * 
     * @param string $list
     * @param string $rules
     * @return string
     */
    public function getJs($list, $rules)
    {
        return <<<EOF
<script type="text/x-magento-init">
    {
        "#custom_rates": {
            "AAllen_UspsCustomRates/js/rates": {
                "button": "#addRule",
                "value": "#customRatesValue",
                "methods": "$list",
                "rules": "$rules"
            }
        }
    }
</script>
EOF;
    }

    /**
     * Get the HTML attributes
     *
     * @return string[]
     */
    public function getHtmlAttributes()
    {
        return [
            'title',
            'class',
            'style',
            'onclick',
            'onchange',
            'disabled',
            'size',
            'tabindex',
            'data-form-part',
            'data-role',
            'data-action'
        ];
    }

    /**
     * Get the default HTML
     *
     * @return string
     */
    public function getDefaultHtml()
    {
        $result = $this->getNoSpan() === true ? '' : '<span class="field-row">' . "\n";
        $result .= $this->getLabelHtml();
        $result .= $this->getElementHtml();

        if ($this->getSelectAll() && $this->getDeselectAll()) {
            $result .= '<a href="#" onclick="return ' .
                $this->getJsObjectName() .
                '.selectAll()">' .
                $this->getSelectAll() .
                '</a> <span class="separator">&nbsp;|&nbsp;</span>';
            $result .= '<a href="#" onclick="return ' .
                $this->getJsObjectName() .
                '.deselectAll()">' .
                $this->getDeselectAll() .
                '</a>';
        }

        $result .= $this->getNoSpan() === true ? '' : '</span>' . "\n";

        $result .= '<script type="text/javascript">' . "\n";
        $result .= '   var ' . $this->getJsObjectName() . ' = {' . "\n";
        $result .= '     selectAll: function() { ' . "\n";
        $result .= '         var sel = $("' . $this->getHtmlId() . '");' . "\n";
        $result .= '         for(var i = 0; i < sel.options.length; i ++) { ' . "\n";
        $result .= '             sel.options[i].selected = true; ' . "\n";
        $result .= '         } ' . "\n";
        $result .= '         return false; ' . "\n";
        $result .= '     },' . "\n";
        $result .= '     deselectAll: function() {' . "\n";
        $result .= '         var sel = $("' . $this->getHtmlId() . '");' . "\n";
        $result .= '         for(var i = 0; i < sel.options.length; i ++) { ' . "\n";
        $result .= '             sel.options[i].selected = false; ' . "\n";
        $result .= '         } ' . "\n";
        $result .= '         return false; ' . "\n";
        $result .= '     }' . "\n";
        $result .= '  }' . "\n";
        $result .= "\n" . '</script>';

        return $result;
    }

    /**
     * Get the  name of the JS object
     *
     * @return string
     */
    public function getJsObjectName()
    {
        return $this->getHtmlId() . 'ElementControl';
    }

    /**
     * @param array $option
     * @param array $selected
     * @return string
     */
    protected function _optionToHtml($option, $selected)
    {
        $html = '<div><input type="text" value="' . $this->_escape($option['value']) . '" name="' . $this->getName() . '"/></div>';
        if (in_array((string)$option['value'], $selected)) {
            $html .= '*';
        }

        /*$html = '<option value="' . $this->_escape($option['value']) . '"';
        $html .= isset($option['title']) ? 'title="' . $this->_escape($option['title']) . '"' : '';
        $html .= isset($option['style']) ? 'style="' . $option['style'] . '"' : '';
        if (in_array((string)$option['value'], $selected)) {
            $html .= ' selected="selected"';
        }
        $html .= '>' . $this->_escape($option['label']) . '</option>' . "\n";*/
        return $html;
    }
}
