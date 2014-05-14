<?php
require('function/include.php');

$main->content->setAuto(false);
$main->content->setCheckLogin(true, false, true);
$main->content->setTitle('Admin');

echo '<pre>'; print_r($main->cookie->getall()); echo '</pre>';