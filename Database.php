<?php

  class Database {

    // Database configuration
    private $host = 'localhost';
    private $dbname = 'db';
    private $username = 'root';
    private $password = '';

    // Table used in the database
    public static $table = '_users';

    // Connect to database
    public function connect() {
      $pdo = null;
      // Setting Data Source Name (dsn)
      $dsn = "mysql:host=$this->host; dbname=$this->dbname; charset=UTF8";
      try { 
        // Create a PHP Data Object (pdo)
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      } catch(PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo "Connection Error: {$e->getMessage()}";
      }  
      return $pdo;
    }

  } // end: class Database
  