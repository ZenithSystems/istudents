<?php
require('function/include.php');

$main->content->setCheckLogin(false);
if($_POST && $_POST['action'] == 'login') {
  $main->content->setAuto(false);
  $main->login->get();
  exit();
} else {
  $token = $main->generater->generateRandomString();
  $main->cookie->add('secTok', $token, 300);
  $continue = isset($_REQUEST['lastPage']) ? ' value="'.base64_encode($_REQUEST['lastPage']).'"':'';
}
$main->content->setTitle(SiteName.' :: เข้าสู่ระบบ');
$main->content->setContent('
	<h3 class="text-center">Login</h3>
    <form action="" method="post">
      <input type="hidden" name="action" value="login">
      <input type="hidden" name="continue"'.$continue.'>
      <input type="hidden" name="timeStmp" value="'.time().'">
      <input type="hidden" name="secTok" value="'.$token.'">
      <table class="table">
        <tr>
          <td>E-Mail:</td>
          <td><input type="text" name="username" class="form-control"></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input type="password" name="password" class="form-control"></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" class="btn btn-default" value="Login"></td>
        </tr>
      </table>
    </form>
', 'header');
?>