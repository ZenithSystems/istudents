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
 * Encrypt
 *
 * เอาใว้ใช้ เข้ารหัสข้อมูล ในระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class encrypt {
  public $encryption_key = 'keyoflibraryphoominproject'; // key เฉพาะ ใครเอาไปใช้จำเป็นต้องเปลี่ยน อนาคตอาจไม่ได้อยู่ตรงนี้
  private $_hash_type = 'adler32'; // hash ที่เอาใว้เข้ารหัส ไม่จำเป็นต้องตั้งใหม่ แต่ท่าตั้งใหม่ก็ดี
  private $_mcrypt_exists = FALSE;
  private $_mcrypt_cipher;
  private $_mcrypt_mode;
  
  public function __construct() {
    $this->_mcrypt_exists = (!function_exists('mcrypt_encrypt')) ? FALSE:TRUE;
  }
  
  public function get_key($key = '') {
    if($key == '') {
      if($this->encryption_key != '') {
        return $this->sha512adler32($this->encryption_key);
      }
      
      $key = $this->sha512adler32($this->encryption_key);
      
      if($key == FALSE) {
        exit('ไม่มี key');
      }
    }
    return $this->sha512adler32($key);
  }
  
  public function set_key($key = '') {
    $this->encryption_key = $key;
  }
  
  public function encode($string, $key = '') {
    $key = $this->get_key($key);
    
    if($this->_mcrypt_exists === TRUE) {
      $enc = $this->mcrypt_encode($string, $key);
    } else {
      $enc = $this->_xor_encode($string, $key);
    }
    return base64_encode($enc);
  }
  
  public function decode($string, $key = '') {
    $key = $this->get_key($key);
    
    if(preg_match('/[^a-zA-Z0-9\/\+=]/', $string)) {
      return FALSE;
    }
    
    $dec = base64_decode($string);
    
    if($this->_mcrypt_exists === TRUE) {
      if(($dec = $this->mcrypt_decode($dec, $key)) === FALSE) {
        return FALSE;
      }
    } else {
      $dec = $this->_xor_decode($dec, $key);
    }
    return $dec;
  }
  
  public function encode_from_legacy($string, $legacy_mode = MCRYPT_MODE_ECB, $key = '') {
    if($this->_mcrypt_exists === FALSE) {
      return FALSE;
    }
    
    $current_mode = $this->_get_mode();
    $this->set_mode($legacy_mode);
    
    $key = $this->get_key($key);
    
    if(preg_match('/[^a-zA-Z0-9\/\+=]/', $string)) {
      return FALSE;
    }
    
    $dec = base64_decode($string);
    
    if(($dec = $this->mcrypt_decode($dec, $key)) === FALSE) {
      return FALSE;
    }
    
    $dec = $this->_xor_decode($dec, $key);
    
    $this->set_mode($current_mode);
    return base64_encode($this->mcrypt_encode($dec, $key));
  }
  
  private function _xor_encode($string, $key) {
    $rand = '';
    while(strlen($rand) < 32) {
      $rand .= mt_rand(0, mt_getrandmax());
    }
    
    $rand = $this->hash($rand);
    
    $enc = '';
    for($i = 0; $i < strlen($string); $i++) {
      $enc .= substr($rand, ($i % strlen($rand)), 1).(substr($rand, ($i % strlen($rand)), 1) ^ substr($string, $i, 1));
    }
    return $this->_xor_merge($enc, $key);
  }
  
  private function _xor_decode($string, $key) {
    $string = $this->_xor_merge($string, $key);
    
    $dec = '';
    for($i = 0; $i < strlen($string); $i++) {
      $dec .= (substr($string, $i++, 1) ^ substr($string, $i, 1));
    }
    return $dec;
  }
  
  private function _xor_merge($string, $key) {
    $hash = $this->hash($key);
    $str = '';
    for($i = 0; $i < strlen($string); $i++) {
      $str .= substr($string, $i, 1) ^ substr($hash, ($i % strlen($hash)), 1);
    }
    return $str;
  }
  
  public function mcrypt_encode($data, $key) {
    $init_size = mcrypt_get_iv_size($this->_get_cipher(), $this->_get_mode());
    $init_vect = mcrypt_create_iv($init_size, MCRYPT_RAND);
    return $this->_add_cipher_noise($init_vect.mcrypt_encrypt($this->_get_cipher(), $key, $data, $this->_get_mode(), $init_vect), $key);
  }
  
  public function mcrypt_decode($data, $key) {
    $data = $this->_remove_cipher_noise($data, $key);
    $init_size = mcrypt_get_iv_size($this->_get_cipher(), $this->_get_mode());
    
    if($init_size > strlen($data)) {
      return FALSE;
    }
    
    $init_vect = substr($data, 0, $init_size);
    $data = substr($data, $init_size);
    return rtrim(mcrypt_decrypt($this->_get_cipher(), $key, $data, $this->_get_mode(), $init_vect), "\0");
  }
  
  private function _add_cipher_noise($data, $key) {
    $keyhash = $this->hash($key);
    $keylen = strlen($keyhash);
    $str = '';
    
    for($i = 0, $j = 0, $len = strlen($data); $i < $len; ++$i, ++$j) {
      if($j >= $keylen) {
        $j = 0;
      }
      
      $str .= chr((ord($data[$i]) + ord($keyhash[$j])) % 256);
    }
    return $str;
  }
  
  private function _remove_cipher_noise($data, $key) {
    $keyhash = $this->hash($key);
    $keylen = strlen($keyhash);
    $str = '';
    
    for($i = 0, $j = 0, $len = strlen($data); $i < $len; ++$i, ++$j) {
      if($j >= $keylen) {
        $j = 0;
      }
      
      $temp = ord($data[$i]) - ord($keyhash[$j]);
      
      if($temp < 0) {
        $temp = $temp + 256;
      }
      
      $str .= chr($temp);
    }
    return $str;
  }
  
  public function set_cipher($cipher) {
    $this->_mcrypt_cipher = $cipher;
  }
  
  public function set_mode($mode) {
    $this->_mcrypt_mode = $mode;
  }
  
  private function _get_cipher() {
    if($this->_mcrypt_cipher == '') {
      $this->_mcrypt_cipher = MCRYPT_RIJNDAEL_256;
    }
    return $this->_mcrypt_cipher;
  }
  
  private function _get_mode() {
    if($this->_mcrypt_mode == '') {
      $this->_mcrypt_mode = MCRYPT_MODE_CBC;
    }
    return $this->_mcrypt_mode;
  }
  
  public function set_hash($type) {
    $this->_hash_type = $type;
  }
  
  public function hash($str) {
    $type = $this->_hash_type;
    if($type == 'sha512adler32') {
      return $this->sha512adler32($str);
    } else {
      if(!function_exists('hash')) {
        if(!function_exists($type)) {
          if($type == 'md5') {
            return $this->md5($str);
          } else if($type == 'sha1') {
            return $this->sha1($str);
          } else if($type == 'sha256') {
            return $this->sha256($str);
          } else {
            exit('Hash '.$type.' is not sure.');
          }
        } else {
          return $type($str);
        }
      } else {
        return hash($type, $str);
      }
    }
  }
  
  public function md5($str) {
    if(!function_exists('mhash')) {
      require_once('md5.php');
      $md5 = new MD5();
      return $md5->generate($str);
    } else {
      return bin2hex(mhash(MHASH_MD5, $str));
    }
  }
  
  public function sha1($str) {
    if(!function_exists('mhash')) {
      require_once('sha1.php');
      $sha1 = new SHA1();
      return $sha1->generate($str);
    } else {
      return bin2hex(mhash(MHASH_SHA1, $str));
    }
  }
  
  public function sha256($str) {
    if(!function_exists('mhash')) {
      require_once('sha256.php');
      $sha256 = new SHA256();
      return $sha256->generate($str);
    } else {
      return bin2hex(mhash(MHASH_SHA256, $str));
    }
  }
  
  public function sha512adler32($string) {
    $string = hash('sha512', $string);
    $string = hash('adler32', $string);
    return $string;
  }
}
?>