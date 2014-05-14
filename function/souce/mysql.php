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
 * MySQL
 *
 * ระบบ database
 *
 * @package Name
 * @subpackage function
 * @category souce
 * @author phoomin , atoms18
 */
class mysql extends PDO {
  public $query_count = 0;
  public $query = array();
  private $join = '';
  private $query_string = '';
  
  public function __construct($config) {
    try {
      parent::__construct('mysql:host='.$config[0].';dbname='.$config[3].';charset='.$config[4].';', $config[1], $config[2]);
    } catch(PDOException $e) {
      die($e->getMessage());
    }
  }
  
  public function select() {
    $rt = 'SELECT ';
    $args = func_get_args();
    $coun = count($args);
    if($coun == 0) {
      $rt .= '*';
    } else {
      if($coun == 1) {
        if(is_array($args[0])) {
          $rt .= '`'.implode('` `', $args[0]).'`';
        } else {
          $rt1 = explode(' ', $args[0]);
          $rt11 = '';
          foreach($rt1 as $v) {
            $rt111 = trim($v);
            $rt11 .= '`'.$rt111.'` ';
          }
          $rt11 = substr($rt11, 0, -1);
          $rt .= $rt11;
        }
      } else {
        $rt1 = '';
        for($i = 0; $i < $coun; $i++) {
          $rt1 .= '`'.$args[$i].'` ';
        }
        $rt .= substr($rt1, 0, -1);
      }
    }
    $this->query_string = $rt;
    return $this;
  }
  
  public function from($table) {
    $rt  = ' FROM ';
    $rt .= '`'.$table.'` {join} ';
    $this->query_string .= $rt;
    return $this;
  }
  
  public function where($field, $value = NULL, $type = 'AND') {
    $rt = ' WHERE'.$this->_sort($field, $value, $type);
    $this->query_string .= $rt;
    return $this;
  }
  
  public function order_by($field, $sort = 'ASC') {
    $rt  = ' ORDER BY ';
    $rt .= '`'.$field.'` '.$sort;
    $this->query_string .= $rt;
    return $this;
  }
  
  public function limit($min, $max = NULL) {
    $rt  = ' LIMIT ';
    $rt .= $min.(empty($max) ? '':','.$max);
    $this->query_string .= $rt;
    return $this;
  }
  
  public function join($table, $field, $value = NULL, $type = 'AND') {
    $rt = ' JOIN `'.$table.'` ON'.$this->_sort($field, $value, $type);
    $this->join = $rt;
    return $this;
  }
  
  private function _sort($field, $value, $type) {
    $main = Main::getMain();
    $rt = '';
    if(!is_array($field)) {
      $field = array($field => $value);
    }
    foreach($field as $field1 => $value1) {
      $c = is_string($value1) ? '\'':'';
      $field1 = trim($field1);
      $value1 = $main->security->StringProtect(trim($value1));
      if($this->_checkOperator($field1)) {
        $field1 = '`'.$field1.'`';
      } else {
        $field1 = '`'.$field1.'` =';
      }
      $rt .= ' '.$field1.' '.$c.$value1.$c.' '.$type.'';
    }
    $rt = substr($rt, 0, -1);
    $rt = trim($rt, $type);
    $rt = substr($rt, 0, -1).'';
    return $rt;
  }
  
  public function insert($table, $value) {
    $main = Main::getMain();
    $rt  = 'INSERT INTO ';
    $rt .= '`'.$table.'`';
    $field1 = '(';
    $value1 = 'VALUES(';
    if(is_array($value)) {
      foreach($value as $k => $v) {
        $c = is_string($v) ? '\'':'';
        $field1 .= '`'.$k.'`,';
        $value1 .= $c.$main->security->StringProtect($v).$c.',';
      }
      $field1 = substr($field1, 0, -1).')';
      $value1 = ' '.substr($value1, 0, -1).')';
    } else {
      $field1 = $value;
      $value1 = '';
    }
    $rt .= ' '.$field1.$value1;
    $this->query_string = $rt;
    $this->get();
    return $this;
  }
  
  public function update($table, $value) {
    $main = Main::getMain();
    $rt  = 'UPDATE ';
    $rt .= '`'.$table.'` SET ';
    $value1 = '';
    if(is_array($value)) {
      foreach($value as $k => $v) {
        $c = is_string($v) ? '\'':'';
        $value1 .= '`'.$k.'` = '.$c.$main->scu->StringProtect($v).$c.',';
      }
      $value1 = substr($value1, 0, -1);
    } else {
      $value1 = $value;
    }
    $rt .= $value1;
    $this->query_string = $rt;
    return $this;
  }
  
  public function delete() {
    $rt = 'DELETE ';
    $this->query_string = $rt;
    return $this;
  }
  
  public function get($debug = false, $return = false) {
    $rt = $this->query($this->toString(), false, true);
    if($debug === true) {
      $err = parent::errorInfo();
      die($err[2]);
    } else {
      if($rt === false) {
        return false;
      } else {
        $driver = new mysql_driver($rt);
        return $return ? $driver:$driver->result();
      }
    }
  }
  
  public function query($query, $return = false, $get = false) {
    $s = microtime(true);
    $rt = parent::query($query);
    $e = microtime(true) - $s;
    $this->query_count++;
    $this->query[] = array('query' => $query, 'time' => $e);

	if($get === true) {
		return $rt;
      } else {
		if($rt === false) {
			return false;
		} else {
        	$driver = new mysql_driver($rt);
        	return $return ? $driver:$driver->result();
		}
      }
  }
  
  public function toString() {
    $rt = trim($this->query_string);
    if(empty($this->join)) {
      $rt = str_replace('{join}', '', $rt);
    } else {
      $rt = str_replace('{join}', $this->join, $rt);
    }
    $this->query_string = '';
    return $rt.';';
  }
  
  private function _checkOperator($str) {
    $str = trim($str);
    if(preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str)) {
      return true;
    }
    return false;
  }
}

class mysql_driver {
  private $_this;
  
  public function __construct(PDOStatement $pdos) {
    $this->_this = $pdos;
  }
  
  public function __destruct() {
    $this->_this->closeCursor();
  }
  
  public function fetch() {
    return $this->_this->fetch(PDO::FETCH_ASSOC);
  }
  
  public function fetch_object() {
    return $this->_this->fetchObject();
  }
  
  public function fetch_rows() {
    return $this->_this->fetch(PDO::FETCH_NUM);
  }

  public function result() {
    $rt = array();
    while($fetch = $this->fetch()) {
      $rt[] = $fetch;
    }
    return $rt;
  }
  
  public function result_object() {
	$rt = array();
    while($fetch = $this->fetch_object()) {
      $rt[] = $fetch;
    }
    return $rt;
  }
  
  public function result_rows() {
    $rt = array();
    while($fetch = $this->fetch_rows()) {
      $rt[] = $fetch;
    }
    return $rt;
  }
  
  public function count() {
    return $this->_this->rowCount();
  }
}
?>