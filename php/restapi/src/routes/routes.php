<?php
require 'src/config/database.php';
require 'src/controllers/UserController.php';

$database = new Database();
$db = $database->getConnection();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$userId = null;

$controller = new UserController($db, $requestMethod, $userId);
$controller->processRequest();
