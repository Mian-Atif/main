<?php

// Include php JWT implementation library
// https://github.com/firebase/php-jwt/tree/master/src

require_once(__DIR__ . '/vendor/autoload.php');

use Firebase\JWT\JWT;

// Enter the same secret key here: %Your_iSpring_Learn_domain%/settings/sso/jwt
$all_headers=getallheaders();
$jwtString = $all_headers['Auth_key'];
const EXAMPLE_JWT_SECRET_KEY ='********';
const EXAMPLE_JWT_ENCODE_ALG = 'HS256';


$jwtString = $all_headers['Auth_key'];


try
{
    // Add leeway to avoid errors on clock skew.
    // See https://stackoverflow.com/questions/40411014/
    if (property_exists(JWT::class, 'leeway')) {
        JWT::$leeway = max(JWT::$leeway, 60);
       // echo 2;
    }

    $token = JWT::decode($jwtString, EXAMPLE_JWT_SECRET_KEY, [EXAMPLE_JWT_ENCODE_ALG]);
    $email = isset($token->email) ? $token->email : '';
   // echo 4;
    print("User logout Successfully.");
    //echo 5;
}
catch (Exception $e)
{
    // If that user doesn't exist, send a 401 Error
    header('HTTP/1.0 401 Unauthorized');
    exit(0);
}
