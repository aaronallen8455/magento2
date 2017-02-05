<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 1/14/2017
 * Time: 3:24 PM
 */

namespace AAllen\Test\Plugin;


use Magento\Framework\App\ActionFactory;

class DefaultRouter
{
    protected $actionFactory;

    public function __construct(ActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    public function afterMatch(\Magento\Framework\App\Router\DefaultRouter $subject, $result)
    {
        return $this->actionFactory->create('Magento\Framework\App\Action\Redirect');
    }
}