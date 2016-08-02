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
use Magento\Framework\View\Result\PageFactory;

class Render extends Action
{

    protected $_resultPageFactory;

    /** @var BlockFactory $_blockFactory */
    protected $_blockFactory;

    /**
     * Render constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param BlockFactory $blockFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory, BlockFactory $blockFactory)
    {
        $this->_resultPageFactory = $pageFactory;
        $this->_blockFactory = $blockFactory;

        parent::__construct($context);
    }

    /**
     * Build html response string
     *
     * @return null
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

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
        foreach ($blocks as $id) {
            if ($numBlocks-- === 0) break;

            $html .= $resultPage->getLayout()
                ->createBlock('Magento\Cms\Block\Block')
                ->setBlockId($id)
                ->toHtml();
        }
        
        echo $html;

        return null;
    }
}