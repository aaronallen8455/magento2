<?php

namespace AAllen\Faq\Api\Data;

interface FaqInterface
{
    /**
     * Constants for keys of data array.
     */
    const FAQ_ID = 'faq_id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ENABLED = 'is_active';
    const POSITION = 'position';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get question
     *
     * @return string|null
     */
    public function getQuestion();

    /**
     * Get answer
     * 
     * @return string|null
     */
    public function getAnswer();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Get position
     * 
     * @return int
     */
    public function getPosition();

    /**
     * Is enabled
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return FaqInterface
     */
    public function setId($id);

    /**
     * Set question
     *
     * @param string $question
     * @return FaqInterface
     */
    public function setQuestion($question);

    /**
     * Set answer
     *
     * @param string $answer
     * @return FaqInterface
     */
    public function setAnswer($answer);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return FaqInterface
     */
    public function setCreationTime($creationTime);
    
    /**
     * Set update time
     * 
     * @param string $updateTime
     * @return FaqInterface
     */
    public function setUpdateTime($updateTime);
    
    /**
     * Set is enabled
     * 
     * @param int|bool $isActive
     * @return FaqInterface
     */
    public function setIsActive($isActive);
    
    /**
     * Set position
     * 
     * @param int $position
     * @return FaqInterface
     */
    public function setPosition($position);
}