<?php

namespace AAllen\RandomBlock\Block\Widget;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

class RandomBlock extends Template implements BlockInterface
{
    /** @var BlockFactory $_blockFactory */
    protected $_blockFactory;

    /**
     * RandomBlock constructor.
     * @param Context $context
     * @param BlockFactory $blockFactory
     * @param array $data
     */
    public function __construct(Context $context, BlockFactory $blockFactory, array $data)
    {
        parent::__construct($context, $data);

        $this->_isScopePrivate = true;
        $this->_blockFactory = $blockFactory;
        $this->setTemplate('AAllen_RandomBlock::random.phtml');
    }

    /**
     * Get the list of block ids
     *
     * @return string
     */
    public function getRandomBlockIds()
    {
        return $this->getData('ids');
    }

    /**
     * Get the number of blocks to be inserted.
     *
     * @return int
     */
    public function getNumberOfBlocks()
    {
        return (int)$this->getData('numBlocks');
    }
}