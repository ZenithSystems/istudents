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
 * Users
 *
 * เกี่ยวกับระบบผู้ใช้
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class users {
  public static $username;
  
  public function __construct() {
    global $main;
    $user = $main->cookie->get('username');
    self::$username = empty($user) ? false:$user;
  }
  
  public function isLoggedIn() {
    return self::$username === false ? false:true;
  }
  
  public function isAdmin($username = true) {
    $type = $this->getType($username);
    return $type == 'admin';
  }
  
  public function getType($username = true) {
    $main = Main::getMain();
    $username = $username === true ? self::$username:$username;
    $query = $main->mysql->select('type')->from('user')->where('username', $username)->get();
    return $query[0]['type'];
  }
}
?>