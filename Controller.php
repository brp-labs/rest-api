<?php

  class Controller {

    private static $header = [
      'Product' => 'REST API (CRUD)',
      'Version' => '1.0.0',
      'Author' => 'Brian Ravn Pedersen',
      'Created' => '2024-09-18',
      'GitHub' => 'github.com/brp-labs/rest-api'
      ];

    private static $keys = ['id', 'user_id', 'username', 'email', 'entity', 'entitycode']; 

    private static $requiredKeys = ['username', 'email'];
    
    private static $uniqueKeys = ['user_id', 'username', 'email'];

    private $model; // class instance

    // Constructor
    public function __construct($db) {
      $this->model = new Model($db);
    }

    // Validate uniqueness of content (value) of unique keys
    private function validateUniqueKeys($data) {
      foreach(self::$uniqueKeys as $uniqueKey) {
        if (array_key_exists($uniqueKey, $data)) {
          $isUnique = $this->model->isKeyValueUnique($uniqueKey, $data[$uniqueKey]);
          if (!$isUnique) {
            http_response_code(412); // Precondition Failed
            echo json_encode(["Message" => "A post already exists with the value of '$data[$uniqueKey]' at key '$uniqueKey'. Please use a different value for this unique key."]);
            return false;
          }
        }
      }
      return true; // $isUnique is true
    }

    // Validate existens of required keys with content
    private function validateRequiredKeys($data) {
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

    // Create a post
    public function create($data) {
      if ($data) {
        $keysValidated = self::validateRequiredKeys($data); // Required keys
        if ($keysValidated)  {
          $keysValidated = self::validateUniqueKeys($data); // Unique keys
          if ($keysValidated) {
            $createdData = [];
            foreach (self::$keys as $key) {
              $createdData[$key] = isset($data[$key]) ? self::sanitize($data[$key]) : '';
            }
            extract($createdData, EXTR_OVERWRITE);
            $result = $this->model->create($entitycode, $entity, $user_id, $username, $email);
            if ($result) {
              http_response_code(201); // Created
              echo json_encode(['Message' => 'Post created successfully.']);
            } else {
              echo json_encode(['Message' => 'Post creation failed.']);
            }
          }
        } else {
          echo json_encode(["Message" => "Missing required keys with content. Required keys are: ".implode(", ", self::$requiredKeys)]);
        }
      } else {
        http_response_code(400); // Bad Request
        echo json_encode(["Message" => "No data submitted"]);
      } 
    }

    // Read a single post
    public function read_single($id) {
      $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
      $result = $this->model->read_single($id);
      if ($result->rowCount() > 0) {
        $post['Info'] = self::$header;
        $post['Data'] = $result->fetch(PDO::FETCH_ASSOC);
        http_response_code(200); // OK
        // Check if read_single is called from within the current class
        if (isset($backtrace[1]['class']) && $backtrace[1]['class'] === __CLASS__) {
          return $post; // Id est: Return to the update-method
        }
        echo json_encode($post);
      } else {
        http_response_code(404); // Not Found
        echo json_encode(["Message" => "No post found with the specified identifier (id-key)."]);
      }
      return false;
    }
    
    // Read all posts
    public function read_all() {
      $result = $this->model->read_all();
      if ($result->rowCount() > 0) {
        $posts['Info'] = self::$header;
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
    
    // Search for posts
    public function search($search) {
      $search = self::sanitize($search);
      $result = $this->model->search($search);
      if ($result->rowCount() > 0) {
        $posts['Info'] = self::$header;
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
    
    // Update a post
    public function update($data) {
      if (isset($data['id'])) {
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
        }
      } else {
        http_response_code(400); // Bad Request
        echo json_encode(['Message' => 'Missing required identifier: id (numeric)']);
      }  
    }

    // Delete a post
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
    
    
  } // end: class Controller
