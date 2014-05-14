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
 * Dologin
 *
 * ตรวจการ login อีกครั้งหนึ่ง
 *
 * @package Name
 * @author phoomin , atoms18
 */
include_once('function/include.php');
$main->content->setCheckLogin(false);
$main->content->setAuto(false);
class Dologin {
  private $username;
  private $continues;
  
  public function check() {
    $main = Main::getMain();
    foreach($_GET as $k => $v) {
      $_GET[$k] = $main->security->StringProtect(urldecode($v));
    }
    $i = 1;
    $timesnew = strtotime('-1 hours');
    $secTok = $main->cookie->get('secTok');
    if(!empty($_GET['continue'])) {
      $this->continues = base64_decode($_GET['continue']);
    } else {
      $this->continues = $main->path_url;
    }
    if($_GET['timeStmp'] > $timesnew) {
      $i++;
    }
    if($_GET['secTok'] == $secTok) {
      $i++;
    }
    $login = $main->mysql->select()->from('user')->where(array(
      'username' => $_GET['username'],
      'password' => $main->encrypt->sha512adler32($_GET['password'])
    ))->get(false, true);
    $count = $login->count();
    $fetch = $login->fetch();
    if($count == 1) {
      $i++;
      if($main->encrypt->sha512adler32($_GET['password']) == $fetch['password']) {
        $i++;
        $this->username = $fetch['username'];
      }
    }
    return $i;
  }
  
  public function redirect($i) {
    $main = Main::getMain();
    $syui = $main->ui;
    header('Content-Type: text/html; charset=utf-8');
    if($i == 5) {
      echo 'รอสักครู่...';
      $main->cookie->del('secTok');
      $main->cookie->add('username', $this->username);
      $syui->menu->get(true, $this->username);
      header('Refresh: 3; url='.$this->continues);
    } else {
      echo 'เกิดข้อผิดผลาด!';
      $url = seo_friendly === true ? '../auth/':'login.php';
      $main->redirect->redirectByForm($url, array('action' => ''), true, false);
    }
  }
}
$dos = new Dologin();
if($_GET && isset($_GET['action']) && $_GET['action'] == 'login') {
  $dos->redirect($dos->check());
} else {
  $dos->redirect(0);
}
?>