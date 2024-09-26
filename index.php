<?php

/* 
    REST API (CRUD) - with the ability to perform string searches as well.
    Design Pattern: MVC (Model, View, Controller)
    Author: Brian Ravn Pedersen, Data Engineer and Software Developer
    Created: 2024-09-18
    GitHub Repository: https://github.com/brp-labs/rest-api
    ______________________________________________________________________
*/
    
  // Headers
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, Authorization');

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

    // POST -> Create a post
    case 'POST':
      $data = json_decode(file_get_contents('php://input')); // Type: object
      $controller->create((array)$data); // Cast into an array
      break;
      
    // GET -> Read a single post, Search for posts, Read all posts
    case 'GET':
      // Read a single post
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $post = $controller->read_single($id);
      // Search for posts  
      } elseif (isset($_GET['q']))  {
        $search = $_GET['q'];
        $posts = $controller->search($search);
      // Read all posts 
      } else {
        $posts = $controller->read_all();
      }
      break;

    // PUT -> Update a post
    case 'PUT':
      $data = json_decode(file_get_contents('php://input'), true);
      $controller->update($data);
      break;

    // DELETE -> Delete a post
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




