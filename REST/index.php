<?php
spl_autoload_register('spl_autoload');
$r = new Restler();
// $r->refreshCache(); // uncomment momentarily to clear the cache if classes change in production mode
$r->addAPIClass('TestController', '/');
$r->handle();
?>