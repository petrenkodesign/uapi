<?php
//---Universal API ------------
//---created by Alex Petrenko
//---http://petrenkodesign.com
//---petrenkodesign@gmail.com
//-----------------------------
class get_api {
    protected $ercode='error 800';
    //do=select,update,insert&src=table&value={id:1}&data=[{id:1,name:User,pass:password}]
    public function get_api() {
      $do = $this->ch_post_key('do');
      $this->apido($do);
    }
    
    protected function apido($do) {
      $src = $this->ch_post_key('src');
      $value = $this->ch_post_key('value', 'noexit');
      $where = $this->query_where($value);
      $dbfun = new dbfun();
      switch ($do) {
				case 'select':
				  $secfun = new secfun();
					$sql = "SELECT * FROM $src $where";
					$result = $dbfun->query($sql);
					return $result ? $this->_error($secfun->jencode($result)) : $this->_error();
				break;
				case 'update':
				  if (!$where) return $this->_error();
				  $data = $this->get_data();
				  foreach ($data as $key=>$value) {
				    $sql = "UPDATE $src SET `$key`='$value' $where";
				  }
				  $result = $dbfun->query($sql);
				  return $result ? $this->_error('ok') : $this->_error();
				break;
				case 'insert':
				  $data = $this->get_data();
				  foreach ($data as $key=>$value) {
				    $sql = "INSERT INTO $src ($key) VALUES ($value)";
				    $result = $dbfun->query($sql);
				    if (!$result) $this->_error();
				  }
				  $this->_error('ok');
				break;
				case 'delete':
				  if (!$where) return $this->_error();
				  $sql = "DELETE FROM $src $where";
				  $result = $dbfun->query($sql);
				  return $result ? $this->_error('ok') : $this->_error();
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
    
    protected function ch_post_key($key, $ercode=$this->ercode) {
      $result = $this->ch_arr_key($this->get_postdata(), $key, $ercode);
      return $result ? $result : $this->_error($ercode);
    }
    
    protected function _error($ercode=$this->ercode) {
		  if($ercode=='noexit') return false;
		  else exit($ercode);
	  }
	  
	  protected function query_where($value) {
      $value = json_decode($value, true);
			if(!$value) return false;
			foreach($value as $key=>$val) {
			  if($val === reset($value))	$where = 'WHERE ';
				else $where = $where.' and ';
				//if($mode === 'search') $val = '%'.$val.'%'; // 
				$where = $where.$key.' LIKE \''.$val.'\'';
			}
		  return isset($where) ? $where : false;
	  }
}
?>
