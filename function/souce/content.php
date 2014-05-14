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
 * Content
 *
 * เอาใว้ control ส่วนแสดงผลของระบบ
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class content {
  private $file_content = '';
  private $path_template = '';
  private $check_login = array(true, true, false);
  private $auto_display = true;
  private $path_all_template = array();
  private $path_templath_default = 'theme/default';
  private $file_request = array(
  	'header',
    'footer'
  );
  private $text_pattern_default = array(
  	'doctype' => '<!DOCTYPE html>',
    'lang' => 'th',
    'charset' => 'utf-8',
    'title' => '',
    'head' => '',
    'content' => ''
  );
  
  public function __construct() {
    $this->setPathTemplate($this->path_templath_default);
  }
  
  public function __destruct() {
    $main = Main::getMain();
    $this->toHTML();
    echo '<div style="z-index: 9999; position: relative;">@ '.$main->util->byte_format(memory_get_usage(), 2).' in '.number_format(microtime(true) - start_time, 4).' Sec with '.$main->mysql->query_count.' command.<pre><ol>';
	foreach($main->mysql->query as $value) {
      echo '<li>"'.$value['query'].'" in '.$value['time'].' Sec.</li>';
	}
    echo '</ol></pre></div>';
  }
  
  public function toHTML() {
    $main = Main::getMain();
    $logged = $main->users->isLoggedIn();
    if($this->check_login[1]) {
      if($logged) {
        header('Location: '.$main->path_url);
        exit();
      }
    }
    if($this->check_login[0]) {
      if(!$logged) {
        header('Location: '.$main->path_url.'login.php?lastPage='.$_SERVER['REQUEST_URI']);
        exit();
      }
    }
    if($this->check_login[2]) {
      if(!$main->users->isAdmin()) {
        header('Location: '.$main->path_url);
        exit();
      }
    }
    if($this->auto_display) {
      $systemui = $main->ui;
      foreach($this->file_request as $value) {
        $content = $this->path_all_template[$value];
        if(!empty($this->file_content)) {
          $content = str_replace('[content]', $this->path_all_template[$this->file_content], $content);
        }
        foreach($this->text_pattern_default as $key => $value) {
          $content = str_replace('['.$key.']', $value, $content);
        }
        $this->drawLayout(true, '', $content);
      }
    }
  }
  
  public function drawLayout($permission, $layout, $content = '') {
    if($permission) {
      $main = Main::getMain();
      $systemui = $main->ui;
      if(empty($content) && !empty($layout)) {
        $content = $this->path_all_template[$layout];
      }
      echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', $content)));
    }
  }
  
  public function setAuto($set) {
    $this->auto_display = $set;
  }
  
  public function setCheckLogin($log1 = true, $log2 = true, $log3 = false) {
    $this->check_login = array($log1, $log2, $log3);
  }
  
  public function setPathTemplate($path) {
    global $main;
    if(empty($this->path_template) || $this->path_template != $path) {
      $this->path_template = $path;
      $this->path_all_template = array();
    }
    $path .= '/';
    $dir = scandir($path);
    foreach($dir as $value) {
      if($value != '.' && $value != '..') {
        if(is_dir($main->path_file.$path.$value)) {
          $this->setPathTemplate($main->path_file.$path.$value);
        } else {
          $file = str_replace('.php', '', $value);
          $this->path_all_template[$file] = file_get_contents($path.$value);
        }
      }
    }
  }
  
  public function setDoctype($content, $layout = 'header') {
    return $this->set_template('doctype', $content, $layout);
  }
  
  public function setLang($content, $layout = 'header') {
    return $this->set_template('lang', $content, $layout);
  }
  
  public function setCharset($content, $layout = 'header') {
    return $this->set_template('charset', $content, $layout);
  }
  
  public function setTitle($content, $layout = 'header') {
    return $this->set_template('title', $content, $layout);
  }
  
  public function setHead($content, $layout = 'header') {
    return $this->set_template('head', $content, $layout);
  }
  
  public function setContent($content, $layout = 'content') {
    $this->file_content = $layout;
    return $this->set_template('content', $content, $layout);
  }
  
  public function set_template($mark, $content, $layout) {
    $this->path_all_template[$layout] = str_replace('['.$mark.']', $content, $this->path_all_template[$layout]);
    return $this;
  }
}
?>