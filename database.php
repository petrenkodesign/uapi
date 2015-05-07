<?php
//---Universal API ------------
//---created by Alex Petrenko
//---http://petrenkodesign.com
//---petrenkodesign@gmail.com
//-----------------------------
class dbfun {
    protected $mysqli='';
    
    public function dbfun() {
      // Create connection
      $this->mysqli=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      // Check connection
      if ($this->mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      // Set database charset
      $this->mysqli->set_charset("utf8");
    }
    
    public function query($sql) {
      // Start query
      $result = $this->mysqli->query($sql);
      // Exit with showing query error
      if ($this->mysqli->error) {
        echo "Error: " . $sql . "<br>" . $this->mysqli->error;
        exit;
      }
      //If SELECT get data
      if(is_object($result)) $result = $result->fetch_assoc();
      //Return result
      return $result;
    }
    
    public function close() {
      //Close mysqli session
      $this->mysqli->close();
    }
}
?>
