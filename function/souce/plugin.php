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
 * Plugin
 *
 * ตัวควบคุม plugin ในระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class plugin {
  public $name;
  public $file;
  protected $main;
  protected $mysql;
  
  public function init($main) {
    $this->main = $main;
    $this->mysql = $main->mysql;
  }
  
  public function install() {
    $this->mysql->update('plugin', array('enable' => 'true'))->where('name', $this->name);
  }
  
  public function uninstall() {
    $this->mysql->update('plugin', array('enable' => 'false'))->where('name', $this->name);
  }
  
  public function getPluginXML() {
    $xml = simplexml_load_file($this->file);
    return $xml;
  }
}
?>