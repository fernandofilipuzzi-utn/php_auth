<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

class UserController {
    private $db;
    private $requestMethod;
    private $userId;

    private $secret_key = "your_secret_key";

    public function __construct($db, $requestMethod, $userId) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->login();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function login() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateLogin($input)) {
            return $this->unprocessableEntityResponse();
        }

        $user = new User($this->db);
        $user->username = $input['username'];
        $user->password = $input['password'];

        if ($user->login()) {
            $token = $this->generateJwt($user->id);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode([
                'token' => $token
            ]);
            return $response;
        } else {
            return $this->notFoundResponse();
        }
    }

    private function generateJwt($userId) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // jwt válido por 1 hora

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $userId
        ];

        return JWT::encode($payload, $this->secret_key);
    }

    private function validateLogin($input) {
        if (!isset($input['username']) || !isset($input['password'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse() {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'error' => 'User not found'
        ]);
        return $response;
    }
}
