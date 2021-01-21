<?php
//Database connection Controller
  class Database {
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_NAME;

    private $statement;
    private $dbHandler;
    private $error;
    private static $obj;

    //singleton pattern implementation
    private function __construct() {
      $conn = 'sqlite:' . $this->dbName;
      $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );
      try {
        $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
      } catch (PDOException $e) {
        $this->error = $e->getMessage();
        echo $this->error;
      }
    }

    // Using Singleton pattern
    public static function getConnect() { 
      if (!isset(self::$obj)) { 
        self::$obj = new DataBase(); 
      }     
      return self::$obj; 
    }

    public function dbConnection() {
        return $this->dbHandler;
    }

    //Allows us to write queries
    public function query($sql) {
      $this->statement = $this->dbHandler->prepare($sql);
    }

    //Bind values
    public function bind($parameter, $value, $type = null) {
      switch (is_null($type)) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
      $this->statement->bindValue($parameter, $value, $type);
    }

    //Execute the prepared statement
    public function execute() {
      return $this->statement->execute();
    }

    //Return an array ( recordset )
    public function resultSet() {
      $this->execute();
      return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    //Return a specific row as an object
    public function single() {
      $this->execute();
      return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    //Get's the row count
    public function rowCount() {
      return $this->statement->rowCount();
    }
    
  }
  