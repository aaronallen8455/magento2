<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/30/2016
 * Time: 1:49 AM
 */

namespace AAllen\FooterLinks\Block;


class Links extends \Magento\Framework\View\Element\Html\Links
{
    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        $html = '';

        // if footer flag is set, draw as columns
        if ($this->getLinks()) {
            $columnSize = $this->getData('column_size') ? (int)$this->getData('column_size') : 5;
            if ($this->getData('is_footer') == true) {
                $counter = 0;
                foreach ($this->getLinks() as $link) {
                    if ($counter === 0) {
                        $html .= $this->ulTag();
                    }

                    $html .= $this->renderLink($link);

                    $counter++;
                    if ($counter === $columnSize) {
                        $html .= '</ul>';
                        $counter = 0;
                    }
                }
            } else {
                $html = $this->ulTag();
                foreach ($this->getLinks() as $link) {
                    $html .= $this->renderLink($link);
                }
                $html .= '</ul>';
            }
        }

        return $html;
    }

    protected function ulTag()
    {
        return '<ul' . ($this->hasCssClass() ? ' class="' . $this->escapeHtml(
                $this->getCssClass()
            ) . '"' : '') . '>';
    }
}