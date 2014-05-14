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
 * Util
 *
 * function อื่นๆ ที่จะได้ใช้ในระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class util {
  public function array_insert(&$array, $insert, $position = -1) {
    $position = ($position == -1) ? (count($array)) : $position;
    if($position != (count($array))) {
      $ta = $array;
      for($i = $position; $i < (count($array)); $i++) {
        if(!isset($array[$i])) {
          //die(print_r($array, 1)."\r\nInvalid array: All keys must be numerical and in sequence.");
        }
        $tmp[$i + 1] = $array[$i];
        unset($ta[$i]);
      }
      $ta[$position] = $insert;
      $array = $ta + $tmp;
    } else {
      $array[$position] = $insert;
    }
    sort($array);
    return $array;
  }
  
  public function byte_format($num, $precision = 2) {
    if($num >= 1000000000000) {
      $num = round($num / 1099511627776, $precision);
      $unit = 'TB';
    } elseif($num >= 1000000000) {
      $num = round($num / 1073741824, $precision);
      $unit = 'GB';
    } elseif($num >= 1000000) {
      $num = round($num / 1048576, $precision);
      $unit = 'MB';
    } elseif($num >= 1000) {
      $num = round($num / 1024, $precision);
      $unit = 'KB';
    } else {
      $unit = 'B';
      return number_format($num).' '.$unit;
    }
    return number_format($num, $precision).' '.$unit;
  }
}
?>