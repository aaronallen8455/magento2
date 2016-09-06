<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 9/5/2016
 * Time: 5:23 PM
 */

namespace AAllen\Faq\Model;


use AAllen\Faq\Api\Data\FaqInterface;
use Magento\Framework\Model\AbstractModel;

class Faq extends AbstractModel implements FaqInterface
{
    /**#@+
     * Faq's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    protected function _construct()
    {
        $this->_init('AAllen\Faq\Model\ResourceModel\Faq');
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getId()
    {
        return $this->getData(self::FAQ_ID);
    }

    public function getAnswer()
    {
        return $this->getData(self::ANSWER);
    }

    public function getPosition()
    {
        return $this->getData(self::POSITION);
    }

    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    public function getQuestion()
    {
        return $this->getData(self::QUESTION);
    }

    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    public function setAnswer($answer)
    {
        return $this->setData(self::ANSWER, $answer);
    }

    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    public function setIsActive($isActive)
    {
        return @$this->setData(self::IS_ENABLED, $isActive);
    }

    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }

    public function setQuestion($question)
    {
        return $this->setData(self::QUESTION, $question);
    }

    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    public function setId($value)
    {
        return $this->setData(self::FAQ_ID, $value);
    }

    public function isActive()
    {
        return (bool) $this->getData(self::IS_ENABLED);
    }
}