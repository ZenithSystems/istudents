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
 * Main
 *
 * สั่งงานระบบ เกือบทั้งหมดในระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class Main extends Config {
  public $ui;
  public $plugin;
  public $path_url;
  public $path_file;
  private static $instance;
  
  public static function getMain() {
    return self::$instance;
  }
  
  public function start() {
    $this->ui = new stdClass();
    $this->plugin = new stdClass();
    $this->path_url = SiteURI;
    $this->path_file = SiteFile;
    
    $this->setup();
    self::$instance = $this;
  }
  
  private function setup() {
    $this->setSources();
    $this->registerPlugins();
  }
  
  private function setSources() {
    foreach($this->list_source as $k => $v) {
      if(is_array($v)) {
        if(file_exists($this->path_file.'function/souce/'.$v['name'].'.php')) {
          require_once($this->path_file.'function/souce/'.$v['name'].'.php');
          $this->$k = new $v['name']($v['request']);
        } else {
          exit('Class '.$v['name'].' not found.');
        }
      } else {
        if(file_exists($this->path_file.'function/souce/'.$v.'.php')) {
          require_once($this->path_file.'function/souce/'.$v.'.php');
          $this->$k = new $v();
        } else {
          exit('Class '.$v.' not found.');
        }
      }
    }
    foreach($this->list_source_ui as $k => $v) {
      if(is_array($v)) {
        if(file_exists($this->path_file.'function/system/'.$v['name'].'.php')) {
          require_once($this->path_file.'function/system/'.$v['name'].'.php');
          $this->ui->$k = new $v['name']($v['request']);
        } else {
          exit('Class '.$v['name'].' not found.');
        }
      } else {
        if(file_exists($this->path_file.'function/system/'.$v.'.php')) {
          require_once($this->path_file.'function/system/'.$v.'.php');
          $this->ui->$k = new $v();
        } else {
          exit('Class '.$v.' not found.');
        }
      }
    }
  }
  
  private function registerPlugins() {
    $list_file = scandir($this->path_file.'function/plugin');
    unset($list_file[0], $list_file[1]);
    sort($list_file);
    foreach($list_file as $value) {
      $file = $this->path_file.'function/plugin/'.$value.'/plugin.xml';
      $xml = simplexml_load_file($file);
      require_once($this->path_file.'function/plugin/'.$value.'/'.$xml->class.'.php');
      eval('$this->plugin->'.$xml->name.' = new '.$xml->class.'();');
      $this->plugin->{$xml->name}->name = $xml->name;
      $this->plugin->{$xml->name}->file = $file;
      $this->plugin->{$xml->name}->init($this);
    }
  }
}
?>