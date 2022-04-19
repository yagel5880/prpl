<?php 

    class Database extends mysqli{
      
      // DB Params
      private $host = 'localhost';
      private $db = 'yagelnew_web';
      private $user = 'yagelnew_prpl';
      private $pass = 'bETJHuDk4w';
      private $conn;

      // DB Connect
      public function __construct(){
          parent::__construct($this->host, $this->user, $this->pass, $this->db);
      }
    
      public function escape($str){
          return parent::real_escape_string($str);
      }
      
      public function query($query, $resultmode = NULL){
          global $log;
          $log[] = $query;
          return parent::query($query);
      }
    
      public function fetch($res){
          return parent::$mysqli->fetch_assoc($res);
      }
      
      public function __destruct(){
          parent::close();
      }
  }