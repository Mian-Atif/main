<?php
include "conn.php";
require_once 'verification.php';

header('Access-Control-Allow-Origin: *','token');
$response = ['error' => true , 'message' => '' ,'status' => 200];
$email_pattren = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
//$name_pattern = "/^[a-zA-Z]+$/";

$input_data = json_decode(file_get_contents("php://input"),true);

$all_headers = getallheaders();

    if(!empty($all_headers['Auth_key'])){      

        $jwt=$all_headers['Auth_key'];

        $verification = new Verification();

        $verify_token=$verification->verifyKey($jwt);

        if($verify_token['status']===true){

           $merchent_name    = $verify_token['data']->name;
           $merchent_emai    = $verify_token['data']->email;
           $merchent_company = $verify_token['data']->Company_name;
           $merchent_id      = $verify_token['data']->user_id;
           $marchent_balance =$verify_token['data']->Balance;
           
           
        echo "$$merchent_id\n,$$merchent_name\n,$merchent_emai\n,$merchent_company\n,$marchent_balance";
        

        }
    }


?>