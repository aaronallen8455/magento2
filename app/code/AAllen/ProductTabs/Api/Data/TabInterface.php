<?php


namespace AAllen\ProductTabs\Api\Data;

interface TabInterface
{

    const TAB_ID = 'tab_id';
    const POSITION = 'position';
    const LABEL = 'label';
    const CONTENT = 'content';


    /**
     * Get tab_id
     * @return string|null
     */
    public function getTabId();

    /**
     * Set tab_id
     * @param string $tab_id
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     */
    public function setTabId($tabId, $tab_id);

    /**
     * Get position
     * @return string|null
     */
    public function getPosition();

    /**
     * Set position
     * @param string $position
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     */
    public function setPosition($position);

    /**
     * Get label
     * @return string|null
     */
    public function getLabel();

    /**
     * Set label
     * @param string $label
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     */
    public function setLabel($label);

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     */
    public function setContent($content);
}
