<?php
// Incluir las dependencias necesarias
require '../vendor/autoload.php';
require '../src/routes/routes.php';

// Configuración de encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Aquí se pueden definir más configuraciones si es necesario

// Procesar las rutas
require '../src/routes/routes.php'; // Corregido: archivo routes.php