<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 6/23/2016
 * Time: 6:37 PM
 */

namespace AAllen\RandomBlock\Controller\Action;


use Magento\Cms\Model\Block;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\LayoutInterface;

class Render extends Action
{
    /** @var LayoutInterface $_layout */
    protected $_layout;

    /** @var BlockFactory $_blockFactory */
    protected $_blockFactory;

    /**
     * Render constructor.
     * @param Context $context
     * @param LayoutInterface $layoutInterface
     * @param BlockFactory $blockFactory
     */
    public function __construct(Context $context, LayoutInterface $layoutInterface, BlockFactory $blockFactory)
    {
        $this->_layout = $layoutInterface;
        $this->_blockFactory = $blockFactory;
        
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return null
     */
    public function execute()
    {
        $html = '';
        $ids = $this->getRequest()->getParam('ids');
        $numBlocks = (int)$this->getRequest()->getParam('num');

        // make id list into an array and shuffle it
        $ids = preg_split('/\D+/', $ids);
        $blocks = [];
        //generate blocks from the specified IDs
        foreach ($ids as $id) {
            /** @var Block $block */
            $block = $this->_blockFactory->create()->load((int)$id);
            if ($block->getId()) {
                $blocks[] = (int)$id;
            }
        }
        shuffle($blocks);
        
        //build the html response
        for ($i = 0; $i < $numBlocks; $i++) {
            $html .= $this->_layout
                ->createBlock('Magento\Cms\Block\Block')
                ->setBlockId($blocks[$i])
                ->toHtml();
        }
        
        echo $html;

        return null;
    }
}