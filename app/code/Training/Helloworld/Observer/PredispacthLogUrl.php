<?php
/**
 * Created by PhpStorm.
 * User: training
 * Date: 9/11/18
 * Time: 10:18 AM
 */

namespace Training\Helloworld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use Psr\Log\LoggerInterface;

class PredispacthLogUrl implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PredispacthLogUrl constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer) {
        /** @var Request $request */
        $request = $observer->getEvent()->getData('request');
        $url = $request->getPathInfo();
        $this->logger->info('Current Url : '.$url);
    }
}