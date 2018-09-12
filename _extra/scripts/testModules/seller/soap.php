<?php
require __DIR__.'/../_tools/init.php';

// Initialize the client
$client = new \SmileCoreTest\SoapClient();
$client->setDebug(true);
$client->setMagentoParams($params);
$client->addService('sellerSellerRepositoryV1');

$client->sellerSellerRepositoryV1GetById(['customerId' => 1]);


