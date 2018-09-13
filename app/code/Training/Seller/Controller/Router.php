<?php
/**
 * Created by PhpStorm.
 * User: training
 * Date: 9/13/18
 * Time: 11:23 AM
 */

namespace Training\Seller\Controller;

use Magento\Framework\App\Action\Forward as ForwardAction;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @param ActionFactory $actionFactory
     */
    public function __construct(
        ActionFactory $actionFactory
    ) {
        $this->actionFactory = $actionFactory;
    }


    /**
     * Match application action by request
     *
     * @param RequestInterface $request
     * @return ActionInterface
     */
    public function match(RequestInterface $request)
    {
        /** @var \Magento\Framework\App\Request\Http $request */
        $url = $request->getPathInfo();

        if ($url === '/sellers.html') {
            $request->setPathInfo('/seller/seller/index');
            return $this->actionFactory->create(ForwardAction::class);
        }

        if (preg_match('%^/seller/(.+)\.html$%', $url, $match)) {
            $request->setPathInfo(sprintf('/seller/seller/view/identifier/%s', $match[1]));
            return $this->actionFactory->create(ForwardAction::class);
        }

        return null;
    }
}