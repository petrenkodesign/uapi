<?php
//---Universal API ------------
//---created by Alex Petrenko
//---http://petrenkodesign.com
//---petrenkodesign@gmail.com
//-----------------------------
define('ERCODE', 'error 800');
define('OKCODE', 'ok');
class get_api {
    public function get_api() {
      $do = $this->ch_post_key('do');
      $this->apido($do);
    }
    
    protected function apido($do) {
      $src = $this->ch_post_key('src');
      $where = $this->query_where();
      $dbfun = new dbfun();
      switch ($do) {
				case 'select':
				  $secfun = new secfun();
					$sql = "SELECT * FROM $src $where";
					$result = $dbfun->query($sql);
					$dbfun->close();
					return $result ? $this->_error($secfun->jencode($result)) : $this->_error();
				break;
				case 'update':
				  if (!$where) return $this->_error();
				  $data = $this->get_data();
				  if(isset($data[0])) $data = $data[0];
				  foreach ($data as $key=>$value) {
				    $sql = "UPDATE $src SET `$key`='$value' $where";
				  }
				  $result = $dbfun->query($sql);
				  $dbfun->close();
				  return $result ? $this->_error(OKCODE) : $this->_error();
				break;
				case 'insert':
				  $data = $this->get_data();
				  foreach ($data as $data) {
				    $col=array_map('trim', $data);
				    $value="'".implode("', '", str_replace("'", "\'", $col))."'";
				    $col = "`".implode("`, `", array_keys($col))."`";
				    $sql = "INSERT INTO $src ($col) VALUES ($value)";
				    $result = $dbfun->query($sql);
				    if (!$result) $this->_error();
				  }
				  $dbfun->close();
				  $this->_error('ok');
				break;
				case 'delete':
				  if (!$where) return $this->_error();
				  $sql = "DELETE FROM $src $where";
				  $result = $dbfun->query($sql);
				  $dbfun->close();
				  return $result ? $this->_error(OKCODE) : $this->_error();
				break;
			}
    }
    
    protected function get_data() {
      $result = $this->ch_post_key('data');
			$result = json_decode($result, true);
			return $result;
    }
      
    protected function get_postdata() {
      if(isset($_GET) and isset($_GET['do'])) $result=$_GET;
      elseif(isset($_POST) and isset($_POST['do'])) $result=$_POST;
      return isset($result) ? $result : false;
    }
    
    protected function ch_arr_key($data=null, $key=null) {
      return isset($data[$key]) ? $data[$key] : false;
    }
    
    protected function ch_post_key($key, $ercode=ERCODE) {
      $result = $this->ch_arr_key($this->get_postdata(), $key, $ercode);
      return $result ? $result : $this->_error($ercode);
    }
    
    protected function _error($ercode=ERCODE) {
		  if($ercode=='noexit') return false;
		  else exit($ercode);
	  }
	  
	  protected function query_where() {
	    $value = $this->ch_post_key('value', 'noexit');
	    $value = json_decode($value, true);
			if(!$value) return false;
			foreach($value as $key=>$val) {
			  if($val === reset($value))	$where = 'WHERE ';
				else $where = $where.' and ';
				//if($mode === 'search') $val = '%'.$val.'%'; // uncomment if you need multi-search
				$where = $where.$key.' LIKE \''.$val.'\'';
			}
		  return isset($where) ? $where : false;
	  }
}
?>
