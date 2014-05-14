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
 * Generater
 *
 * เอาใว้ สุ่ม ข้อความ, ตัวเลข, อื่นๆ ในระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class generater {
  public function generateRandomString($length = 30,$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';) {
    $randomString = '';
    for($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
  }
  public function generater($string) {
    $string = str_replace('A',$this->generateRRandomString(1,'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $string = str_replace('a',$this->generateRRandomString(1,'abcdefghijklmnopqrstuvwxyz');
    $string = str_replace('9',$this->generateRRandomString(1,'0123456789');
    return $string;
  }
}
?>