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
        $this->addClass('select aallen-customrates');
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
}
