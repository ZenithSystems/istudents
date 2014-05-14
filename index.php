<?php
require('function/include.php');

$main->content->setCheckLogin(false, false);
$main->content->setTitle(SiteName.' :: หน้าแรก');
$main->content->setContent(
  'This is content form Template system.'
);
?>