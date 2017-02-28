<?php


namespace AAllen\UrlRewrite\Controller;


use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Message\ManagerInterface;

class Router implements RouterInterface
{
    protected $actionFactory;

    public function __construct(ActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface
     */
    public function match(RequestInterface $request)
    {
        $path = trim($request->getPathInfo(), '/');

        $parts = explode('/', $path);

        if ($parts && $parts[0] === 'rewrite') {


            if (isset($parts[1])) {
                $request->setParams(['background' => $parts[1]]);
            }

            $request->setModuleName('rewrite')
                ->setControllerName('index')
                ->setActionName('index');
            /** @var ActionInterface */
            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
        }

        return null;
    }
}