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
 * Cache
 *
 * เอาใว้ control ระบบ cache ของระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class cache {
  public function save($name, $data, $file = '', $time = 0) {
    $main = Main::getMain();
    if(!empty($file)) {
      $filen = $main->path_file.'cache/'.$file;
      if(file_exists($filen)) {
        unlink($filen);
        $main->mysql->delete()->from('cache')->where('name', $file);
      }
    }
    $file_data = $main->encrypt->encode($data);
    $file_name = $main->generater->generateRandomString();
    $file = fopen($main->path_file.'cache/'.$file_name, 'w');
    $main->cookie->add('cache_'.$name, $file_name);
    if(fwrite($file, $file_data)) {
      $main->mysql->insert('cache', array(
        'name' => $name,
        'file' => $file_name,
        'expire' => (($time === 0) ? 0:time() + $time)
      ));
    }
    fclose($file);
  }
  
  public function load($name, $type) {
    $main = Main::getMain();
    if($main->cookie->chk('cache_'.$name)) {
      $cache = $main->cookie->get('cache_'.$name);
    } else {
      $cache = $main->mysql->select()->from('cache')->where('name', $name)->get();
      $cache = $cache[0]['file'];
      $main->cookie->add('cache_'.$name, $cache);
    }
    $file = $main->path_file.'cache/'.$cache;
    if(file_exists($file)) {
      $filec = $main->encrypt->decode(file_get_contents($file));
      $datac = '';
      switch($type) {
        case 'php': {
          eval($filec);
        }
        break;
        case 'html': {
          $datac = $filec;
        }
        break;
      }
      return $datac;
    }
  }
  
  public function check($name) {
    $main = Main::getMain();
    if(!file_exists($main->path_file.'cache/'.$main->cookie->get('cache_'.$name))) {
      $cache = $main->mysql->select()->from('cache')->where('name', $name)->get(false, true);
      if($cache !== false && $cache->count() >= 1) {
        if(file_exists($main->path_file.'cache/'.$cache->fetch()['file'])) {
          return true;
        }
      }
    } else {
      return true;
    }
    return false;
  }
}
?>