<?php

  class Controller {

    private static $classInfo = [
      'Product' => 'REST API (CRUD)',
      'Version' => '1.0.0',
      'Author' => 'Brian Ravn Pedersen',
      'Created' => '2024-09-18',
      ];

    private static $keys = ['id', 'entitycode', 'entity', 'user_id', 'username', 'email']; 

    private static $requiredKeys = ['username', 'email'];  

    private $model; // class instance

    // Constructor
    public function __construct($db) {
      $this->model = new Model($db);
    }

    // Validate existens of required keys with content
    public function validateKeys($data) {
      foreach(self::$requiredKeys as $key) {
        if (!array_key_exists($key, $data) || empty($data[$key])) {
          return false;
        }
      }
      return true;
    }

    // Sanitize
    private static function sanitize($string) {
      return htmlspecialchars(strip_tags(trim($string)));
    }

    // Create post
    public function create($data) {
      $keysValidated = self::validateKeys($data);
      if ($keysValidated)  {
        $createdData = [];
        foreach (self::$keys as $key) {
          $createdData[$key] = isset($data[$key]) ? self::sanitize($data[$key]) : '';
        }
        extract($createdData, EXTR_OVERWRITE);
        $result = $this->model->create($entitycode, $entity, $user_id, $username, $email);
        if ($result) {
          http_response_code(200); // OK
          echo json_encode(['Message' => 'Post created successfully.']);
        } else {
          echo json_encode(['Message' => 'Post creation failed.']);
        }
      } else {
        echo json_encode(["Message" => "Missing required keys with content. Required keys are: ".implode(", ", self::$requiredKeys)]);
      }  
    }

    // Read all posts
    public function read() {
      $result = $this->model->read();
      if ($result->rowCount() > 0) {
        $posts['Info'] = self::$classInfo;
        $posts['Data'] = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          array_push($posts['Data'], $row);
        }
        http_response_code(200); // OK
        echo json_encode($posts);
      } else {
        http_response_code(404); // Not Found
        echo json_encode(["Message" => "No posts found."]);
      }
    }

    // Read single post
    public function read_single($id) {
      $result = $this->model->read_single($id);
      if ($result->rowCount() > 0) {
        $post['Info'] = self::$classInfo;
        $post['Data'] = $result->fetch(PDO::FETCH_ASSOC);
        http_response_code(200); // OK
        return $post;
      }
      http_response_code(404); // Not Found
      return false;
    }

    // Update post
    public function update($data) {
      $existingPost = $this->read_single($data['id']); // Type: array
      if ($existingPost) {
          $existingPost = $existingPost['Data']; // Leave ['Info'] key behind
          foreach (self::$requiredKeys as $key) {
             if (isset($data[$key]) && empty($data[$key])) {
              echo json_encode(["Message" => "Required keys must have content. Required keys are: ".implode(", ", self::$requiredKeys)]);
              return false;
             }
          }
          $updatedData = [];
          foreach (self::$keys as $key) {
            $updatedData[$key] = isset($data[$key]) ? self::sanitize($data[$key]) : $existingPost[$key];
          }
          extract($updatedData, EXTR_OVERWRITE);
          $result = $this->model->update($id, $entitycode, $entity, $user_id, $username, $email);
          if ($result) {
            http_response_code(200); // OK
            echo json_encode(['Message' => 'Post updated successfully.']);
          } else {
            http_response_code(412); // Precondition Failed
            echo json_encode(['Message' => 'Post update failed. Unchanged data migth have been submitted.']);
          }
      } else {
        http_response_code(404); // Not Found
        echo json_encode(["Message" => "No post found with the specified identifier (id-key)."]);
      }  
    }

    // Delete post
    public function delete($id) {
      $id = self::sanitize($id);
      $result = $this->model->delete($id);
      if ($result) {
        http_response_code(200); // OK
        echo json_encode(['Message' => 'Post deleted successfully.']);
      } else {
        http_response_code(404); // Not Found
        echo json_encode(['Message' => 'Post deletion failed. Post with the specified identifier (id-key) might not exist.']);
      }
    }
    
    // Search post
    public function search($search) {
      $search = self::sanitize($search);
      $result = $this->model->search($search);
      if ($result->rowCount() > 0) {
        $posts['Info'] = self::$classInfo;
        $posts['Data'] = [];
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          array_push($posts['Data'], $row);
        }
        http_response_code(200); // OK
        echo json_encode($posts);
      } else {
        http_response_code(404); // Not Found
        echo json_encode(["Message:" => "No posts found."]);
      }
    }
    
  } // end: class Controller
