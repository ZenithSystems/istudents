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
 * Menu
 *
 * สั่งงานระบบ เมนู หน้าเว็บ และ cache หน้า เมนู โดยใช้ sourc/cache
 *
 * @package Name
 * @subpackage function
 * @category system
 * @author phoomin , atoms18
 */
class menu {
  private $menu = '';
  private $time_update = 300; // อัพเดต cache ในแต่ละครั้งที่ refresh เป็นวินาที
  
  public function get($force = false, $username = true) {
    $main = Main::getMain();
    $name = $main->cookie->get('cache_menu');
    if(!$force && $main->cache->check('menu') === true) {
      $time = filemtime($main->path_file.'cache/'.$name);
      if(($time + $this->time_update) >= time()) {
        return $main->cache->load('menu', 'html');
      }
    }
    $rt = $this->_get($username);
    $main->cache->save('menu', $rt, $name);
    return $rt;
  }
  
  private function _get($username) {
    $main = Main::getMain();
    $query = $main->mysql->select()->from('menu')->where('enable', 'true')->order_by('uniform')->get();
    $type = $main->users->getType($username);
    foreach ($query as $value) {
      $property = $value['property'];
      if(!empty($property)) {
        $property = base64_decode($property);
        $property = unserialize($property);
        if($property['permission'] != $type) {
          continue;
        }
      }
      $explode = explode('-', $value['uniform']);
      $text = base64_decode($value['text']);
      $link = empty($value['link']) ? '#':$value['link'];
      switch(count($explode)) {
        case 1: {
          // floor 1
          $this->menu .= '
        	<li<!--li_detail_'.$explode[0].'-->>
            	<a href="'.$link.'"<!--a_detail_'.$explode[0].'-->>'.$text.' <!--caret_'.$explode[0].'--></a>
                <!--dd1_'.$explode[0].'-->
            </li>
          ';
        }
        break;
        case 2: {
          // floor 1 : floor 2
          $this->menu = str_replace('<!--li_detail_'.$explode[0].'-->', ' class="dropdown"', $this->menu);
          $this->menu = str_replace('<!--a_detail_'.$explode[0].'-->', ' class="dropdown-toggle" data-toggle="dropdown"', $this->menu);
          $this->menu = str_replace('<!--caret_'.$explode[0].'-->', '<b class="caret"></b>', $this->menu);
          $this->menu = str_replace('<!--dd1_'.$explode[0].'-->', '
          		<ul class="dropdown-menu">
                  <!--dd2_'.$explode[0].'-->
                </ul>
            ', $this->menu);
          $this->menu = str_replace('<!--dd2_'.$explode[0].'-->', '
                <li><a href="'.$link.'">'.$text.'</a></li>
                <!--dd2_'.$explode[0].'-->
          ', $this->menu);
        }
        break;
      }
    }
    $this->menu = preg_replace('/<\!\-\-+([a-z0-9])+_+([a-z])+_+([0-9])+\-\->/', '', $this->menu);
    return $this->menu;
  }
}
?>