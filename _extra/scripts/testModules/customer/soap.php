<?php
require __DIR__.'/../_tools/init.php';

// Initialize the client
$client = new \SmileCoreTest\SoapClient();
$client->setDebug(true);
$client->setMagentoParams($params);
$client->addService('customerCustomerRepositoryV1');

$client->customerCustomerRepositoryV1GetById(['customerId' => 1]);


