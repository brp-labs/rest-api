<?php

  class Model {
    
    private $conn = null;
    private $table = null;
    
    // Constructor
    public function __construct($db) {
      $this->conn = $db;
      $this->table = Database::$table;
    }

    // Check if the specified key-value pair already exists in the table
    public function isKeyValueUnique($key, $value) {
      $sql = "SELECT id FROM $this->table WHERE $key = :value LIMIT 1";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':value', $value);
      if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
          return false;
        }
        return true;
      } else {
        echo json_encode(["Error" => $stmt->error]);
        return false;
      }
    }

    // Create post
    public function create($entitycode, $entity, $user_id, $username, $email) {
      $sql = "INSERT INTO $this->table (entitycode, entity, user_id, username, email) VALUES (:entitycode, :entity, :user_id, :username, :email)";
      $stmt = $this->conn->prepare($sql);
      $params = [
        ':entitycode' => $entitycode,
        ':entity' => $entity,
        ':user_id' => $user_id,
        ':username' => $username,
        ':email' => $email
      ];
      if ($stmt->execute($params)) {
        if ($stmt->rowCount() > 0) { // Number of affected rows
          return true;
        }
        return false;
      }
      echo json_encode(["Error" => $stmt->error]);
      return false;
    }
    
    // Read single post
    public function read_single($id) {
      $sql = "SELECT * FROM $this->table WHERE id = :id LIMIT 1";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      return $stmt;
    }
    
    // Read all posts
    public function read_all() {
      $sql = "SELECT * FROM $this->table";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt;
    }
    
    // Search post (by the properties 'username' and 'email')
    public function search($search) {
      $sql = "SELECT * FROM $this->table WHERE username LIKE :username OR email LIKE :email";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindValue(':username', '%'.$search.'%');
      $stmt->bindValue(':email', '%'.$search.'%');
      $stmt->execute();
      return $stmt;
    }

    // Update post
    public function update($id, $entitycode, $entity, $user_id, $username, $email) {
      $sql = "UPDATE $this->table SET entitycode = :entitycode, entity = :entity, user_id = :user_id, username = :username, email = :email WHERE id = :id";
      $stmt = $this->conn->prepare($sql);
      $params = [
        ':id' => $id,
        ':entitycode' => $entitycode,
        ':entity' => $entity,
        ':user_id' => $user_id,
        ':username' => $username,
        ':email' => $email
      ];
      if ($stmt->execute($params)) {
        if ($stmt->rowCount() > 0) { // Number of affected rows
          return true;
        }
        return false;
      }
      echo json_encode(["Error" => $stmt->error]);
      return false;
    }

    // Delete post
    public function delete($id) {
      $sql = "DELETE FROM $this->table WHERE id = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':id', $id);
      if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) { // Number of affected rows
          return true;
        }
      } 
      return false;
    }

  } // end: class Model

