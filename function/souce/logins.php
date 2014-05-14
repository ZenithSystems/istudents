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
 * Login
 *
 * เอาใว้ใช้ในการตรวจสอบ login ของระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class logins {
  public function get() {
    $this->redirect($this->check());
  }
  
  private function check() {
    $main = Main::getMain();
    foreach($_POST as $key => $value) {
      $_POST[$key] = $main->security->StringProtect($value);
    }
    $i = 1;
    $timesnew = strtotime('-1 hours');
    $secTok = $main->cookie->get('secTok');
    if($_POST['timeStmp'] > $timesnew) {
      $i++;
    }
    if($_POST['secTok'] === $secTok) {
      $i++;
    }
    $login = $main->mysql->select('password')->from('user')->where(array(
      'username' => $_POST['username'],
      'password' => $main->encrypt->sha512adler32($_POST['password'])
    ))->get(false, true);
    $count = $login->count();
    $fetch = $login->fetch();
    if($count == 1) {
      $i++;
      if($main->encrypt->sha512adler32($_POST['password']) == $fetch['password']) {
        $i++;
      }
    }
    return $i;
  }
  
  private function redirect($i) {
    $main = Main::getMain();
    header('Content-Type: text/html; charset=utf-8');
    if($i == 5) {
      $url = seo_friendly === true ? '../auth/success':'dologin.php';
      $main->redirect->redirectByForm($url, $_POST, false, true, false, false);
    } else {
      echo 'เกิดข้อผิดผลาด!';
      $url = seo_friendly === true ? '../auth/':'login.php';
      $main->redirect->redirectByForm($url, array('action' => ''), true, false);
    }
  }
}
?>