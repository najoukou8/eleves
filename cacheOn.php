<?php

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;

require __DIR__."/vendor/autoload.php" ;

$cachePool = new FilesystemAdapter(
    $namespace = '',
    $defaultLifetime = 0,
    $directory = "/var/www/html/giqualite/symfony-cache/"
);

/**
 * 15 jours durée de cache , après TOTP obligatoire
 */

$days = 90 ; 
$agalan = $_GET['key'];
$sms = $cachePool->getItem($agalan);

if (!$sms->isHit()) {
    $sms->set("on");
    $sms->expiresAfter(3600*24*$days  );
    $cachePool->save($sms);
} else {
    $sms->set("on");
    $sms->expiresAfter(3600*24*$days );
    $cachePool->save($sms);
}
$content = $sms->get();
echo $content ;