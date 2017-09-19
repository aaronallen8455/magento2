<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 6/9/2017
 * Time: 6:13 PM
 */

namespace AAllen\Sandbox\Plugin;


use Magento\Framework\App\Action\AbstractAction;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Message\ManagerInterface;

class RedirectBack
{
    protected $messager;

    public function __construct(ManagerInterface $manager)
    {
        $this->messager = $manager;
    }

    public function afterExecute(AbstractAction $subject, $result)
    {
        //$this->messager->addSuccessMessage($subject->getRequest()->getServer('HTTP_REFERER') . ' ' . get_class($subject));
        return $result;
    }
}