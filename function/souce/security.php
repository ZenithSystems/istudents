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
 * Security
 *
 * การเปลี่ยนข้อความเป็นในอีกรูปหนึ่ง ที่ปลอดภัย และอื่นๆ ในเรื่่องของ ความปลอดภัย ของระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class Security {
  public function StringProtect($string, $max = NULL, $html = true, $sql = true) {
    if($html === true) { $string = htmlspecialchars($string); }
    if($sql === true) { $string = addslashes($string); }
    $string = preg_replace('/(&#x[0-9]{4};)/', '', $string);
    $string = strip_tags($string);
    if(!empty($max)) { $string = substr($string, $max); }
    if(get_magic_quotes_gpc()) { $string = stripslashes($string); }
    return $string;
  }
  
  public function SQLProtect($sql, $html = false) {
    if($html === true) { $sql = htmlspecialchars($sql); }
    if(get_magic_quotes_gpc()) { $sql = stripslashes($sql); }
    $sql = mysql_real_escape_string($sql);
    return $sql;
  }
  
  public function ValueProtect($value) {
    $value = $this->StringProtect($value);
    if(!is_numeric($value)) { $value = '\''.mysql_real_escape_string($value).'\''; }
    return $value;
  }
}
?>