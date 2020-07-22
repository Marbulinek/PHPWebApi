<?php 
  include_once "../config.php";

  class Database {    
      private $conn;
          
      function __construct()
      {
        $this->connect();
      }    
          
      public function connect()
      {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        $this->conn->set_charset("utf8");
            
        /* check connection */
        if ($this->conn->connect_errno) {
              printf("Connect failed: %s\n", $mysqli->connect_error);
        }
        return $this->conn;
      }
  
      public function query($sql)
      { 
        $res = $this->conn->query($sql);
              if ($res == false)
              {
                    throw new Exception(sprintf("SQL Command error message: %s\n", $this->conn->error));
              }
        return $res;            
      }
      
      public function queryRetID($sql)
      {
        $this->query($sql);
        return $this->conn->insert_id;
      }

      public function escape($variable)
      {
        return $this->conn->real_escape_string($variable);
      }

  }
?>
