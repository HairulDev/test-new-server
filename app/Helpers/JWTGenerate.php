<?php

require __DIR__ . '/../../vendor/autoload.php';

use \Firebase\JWT\JWT;

class JwtGenerator
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function generateJwt()
    {
        $dayExpired = 3653; // 10 Years

        $token = [
            'app' => 'TDC APP',
            'creator' => 'THE DIGITAL CELLAR',
            'year' => 2023,
        ];

        return JWT::encode($token, $this->secretKey, 'HS256', null, [
            'expires_in' => $dayExpired * 86400,
        ]);
    }
}

// Example usage:
$secretKey = 'TDC';
$jwtGenerator = new JwtGenerator($secretKey);
$apiKey = $jwtGenerator->generateJwt();

echo "API KEY:\n";
var_dump($apiKey);

