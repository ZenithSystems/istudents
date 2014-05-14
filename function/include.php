<?php
/**
 * Name
 *
 * โปรแกรม สารสนเทศ
 *
 * @package Name
 * @author phoomin , atoms18
 * @copyright Copyright (c) 2557 - 2558
 * @since Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Include
 *
 * ไว้ใช้สำหรับประกาศตัวแปรแลละ include ทุกๆอย่างที่จะให้ทำงานทั้งหน้า (Framework)
 *
 * @package Name
 * @subpackage function
 * @author phoomin , atoms18
 */
define('start_time', microtime(true));

ini_set('output_buffering', 'On');
ini_set('register_global', 'On');
ini_set('display_errors', 'On');

define('seo_friendly', false);
define('SerialLicense', '555-test');
define('SiteName', 'Cloud Library');
define('SiteURI', 'http://'.$_SERVER['HTTP_HOST'].'/lib/');
define('SiteFile', dirname(__FILE__).'/../');

include_once('function/config.php');
include_once('function/souce/main.php');

$main = new Main();

$main->start();

/******************************************/
class object { public $name = 'atoms18'; }
$obj1 = new stdClass();
$obj2 = (object)array('name' => 'atoms18');
$obj3 = (object)'atoms18';
$obj4 = new object();

$obj1->name = 'atoms18';

$obj1->name; // atoms18
$obj2->name; // atoms18
$obj3->scalar; // atoms18
$obj4->name; // atoms18
?>