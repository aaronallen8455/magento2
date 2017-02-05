<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 1/5/2017
 * Time: 5:57 AM
 */

namespace AAllen\Test\Block;


use Magento\Framework\View\Element\Context;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\View\Element\AbstractBlock;

class Redirect extends AbstractBlock
{
    protected $redirect;

    protected $response;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        array $data = []
    ) {
        $this->redirect = $redirect;
        $this->response = $response;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->redirect->redirect($this->response, 'catalog/product/view/id/1');

        parent::_construct();
    }
}