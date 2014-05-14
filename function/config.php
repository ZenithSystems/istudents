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
 * Config
 *
 * ไฟล์ที่เอาใว้ config ค่าในระบบ ให้เอาไปใช้
 *
 * @package Name
 * @subpackage function
 * @author phoomin , atoms18
 */
class Config {
  public $list_source = array(
    'content' => 'content',
    'encrypt' => 'encrypt',
  	'generater' => 'generater',
    'security' => 'security',
    'cookie' => 'cookie',
    'redirect' => 'redirect',
    'login' => 'logins',
    'cache' => 'cache',
    'util' => 'util',
    'xml' => 'xml',
    'users' => 'users',
    'plguin' => 'plugin',
    'mysql' => array(
      'name' => 'mysql',
      'request' => array(
        'localhost',
        'root',
        'root',
        'test',
        'UTF8'
      ))
  );
  public $list_source_ui = array(
  	'menu' => 'menu',
  );
}
?>