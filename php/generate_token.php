<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

$key = "your-secret-key"; 

$issuedAt = time();
$expirationTime = $issuedAt + 3600; 

$payload = [
    'iss' => 'http://yourdomain.com', // Emisor del token
    'iat' => $issuedAt, // Tiempo en que se generó el token
    'exp' => $expirationTime, // Tiempo de expiración
    'guid' => '1e7265c5-6d76-47bf-a765-0250f2b77a9d', // Datos adicionales que quieras incluir
    'scope' => 'gda gdi' // Scopes o permisos asociados al token
];

$jwt = JWT::encode($payload, $key, 'HS256');

echo json_encode(['token' => $jwt]);
