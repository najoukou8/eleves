<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;

require __DIR__."/vendor/autoload.php" ;

$cachePool = new FilesystemAdapter(
    $namespace = '',
    $defaultLifetime = 0,
    $directory = "/var/www/html/giqualite/symfony-cache/"
);

$days = 90 ;
$agalan = $_GET['key'];
$sms = $cachePool->getItem($agalan);

if (!$sms->isHit()) {
    $sms->set("off");
    $sms->expiresAfter(3600*24*$days);
    $cachePool->save($sms);
} else {
    $sms->set("off");
    $sms->expiresAfter(3600*24*$days);
    $cachePool->save($sms);
}
$content = $sms->get();
echo $content ;