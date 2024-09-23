<?php

  /*  REST API (CRUD): Design Pattern: MVC (Model, View, Controller)
      Version: 1.0.0
      Author: Brian Ravn Pedersen
      Created: 2024-09-18
      Files: Router.php, Database.php, Model.php, Controller.php
      Application has been tested and run on Postman.
      ______________________________________________________________

      CREATE: Use HTTP method: POST
        Send body in JSON-format with at leats the required keys (username, email).
          Ex. { 
               "username": "John Doe",
               "email": "john@doe.com",
               "entity": "Business Intelligence"
              }

      READ: Use HTTP method: GET  
        Read single post (with id=23):
          Ex. ...router.php?id=23
        Read all posts:
          Ex. ...router.php
        Search for posts with q-key:
          Ex. ...router.php?q=<querystring> (fields queried: username, email)
          The contains-method is beeing used i SQL, ie. LIKE '%<querystring>%' 

      UPDATE: Use HTTP method: POST
        Send body in JSON-format with the fields that need to be changed.
        Required keys must not be emptied. Use the id-key in the body in order
        to identify the post to update. The id-key is mandatory.
          Ex. {
                "id": 23,
                "entity": "Development Division"
              }
        
      DELETE: Use HTTP method: GET
        Delete post (with id=23):
          Ex. ...router.php?id=23
    
      ______________________________________________________________
*/
    
  // Headers
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, Authorization');

  if ( 1 === 1 ) {
    echo "The World does stand!";
  }

  // Require dependencies
  require_once 'Database.php';
  require_once 'Model.php';
  require_once 'Controller.php';

  // End OPTIONS-request (preflight)
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
  }

  // Instantiate the database and create a connection
  $database = new Database();
  $db = $database->connect();

  // Instantiate the controller
  $controller = new Controller($db);

  // Detect HTTP method used
  $method = $_SERVER['REQUEST_METHOD'];
  
  // Routing
  switch ($method) {

    // POST -> Create post
    case 'POST':
      $data = json_decode(file_get_contents('php://input')); // gettype($data): object
      if ($data) {
        $controller->create((array)$data); // Cast into an array
      } else {
        http_response_code(400); // Bad Request
        echo json_encode(["Message" => "No data submitted"]);
      }
      break;
      
    // GET -> Read single post, Search posts, Read all posts
    case 'GET':
      // Read single post
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $post = $controller->read_single($id);
        if ($post) {
          echo json_encode($post);
        } else {
          echo json_encode(["Message" => "No post found with the specified identifier (id-key)."]);
        }
      // Search posts  
      } elseif (isset($_GET['q']))  {
        $search = $_GET['q'];
        $posts = $controller->search($search);
      // Read all posts 
      } else {
        $posts = $controller->read();
      }
      break;

    // PUT -> Update post
    case 'PUT':
      $data = json_decode(file_get_contents('php://input'), true);
      if (isset($data['id'])) {
        $controller->update($data);
      } else {
        http_response_code(400); // Bad Request
        echo json_encode(['Message' => 'Missing required identifier: id']);
      }
      break;

    // DELETE -> Delete post
    case 'DELETE':
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $controller->delete($id);
      } else {
        http_response_code(400); // Bad Request
        echo json_encode(["Message" => "Missing required identifier: id"]);
      }
      break;  

    default:
      http_response_code(405); // Method Not Allowed
      echo json_encode(['Message' => 'Method not allowed']);
      break;

  } // end: switch




