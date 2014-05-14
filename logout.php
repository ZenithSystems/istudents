<meta charset="utf-8">
<?php
require_once('function/include.php');
$main->content->setAuto(false);
$main->content->setCheckLogin(true, false);
$main->cookie->del('username');
$main->ui->menu->get(true, false);
echo 'รอสักครู่...';
header('Refresh: 3; url='.$main->path_url);
?>