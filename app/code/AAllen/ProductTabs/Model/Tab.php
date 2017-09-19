<?php


namespace AAllen\ProductTabs\Model;

use AAllen\ProductTabs\Api\Data\TabInterface;

class Tab extends \Magento\Framework\Model\AbstractModel implements TabInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AAllen\ProductTabs\Model\ResourceModel\Tab');
    }

    /**
     * Get tab_id
     * @return string
     */
    public function getTabId()
    {
        return $this->getData(self::TAB_ID);
    }

    /**
     * Set tab_id
     * @param string $tabId
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     */
    public function setTabId($tabId, $tab_id)
    {
        return $this->setData(self::TAB_ID, $tabId);

        return $this->setData(self::TAB_ID, $tab_id);
    }

    /**
     * Get position
     * @return string
     */
    public function getPosition()
    {
        return $this->getData(self::POSITION);
    }

    /**
     * Set position
     * @param string $position
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get label
     * @return string
     */
    public function getLabel()
    {
        return $this->getData(self::LABEL);
    }

    /**
     * Set label
     * @param string $label
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     */
    public function setLabel($label)
    {
        return $this->setData(self::LABEL, $label);
    }

    /**
     * Get content
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set content
     * @param string $content
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }
}
