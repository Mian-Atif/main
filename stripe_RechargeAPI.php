<?php
include"conn.php";
include"stripe_payment.php";
require_once 'verification.php';

header('Access-Control-Allow-Origin: *','token');
$response = ['error' => true , 'message' => '' ,'status' => 200];
$email_pattren = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
//$name_pattern = "/^[a-zA-Z]+$/";

$input_data = json_decode(file_get_contents("php://input"),true);
if(!empty($input_data)) {

$card_number     = $input_data['card_number'];
 $exp_month    = $input_data['exp_month'];
 $exp_year =$input_data['exp_year'];
 $cvc  = $input_data['cvc'];

$all_headers = getallheaders();

    if(!empty($all_headers['Auth_key'])){      

        $jwt=$all_headers['Auth_key'];

        $verification = new Verification();

        $verify_token=$verification->verifyKey($jwt);

        if($verify_token['status']===true){

           $merchent_email   = $verify_token['data']->email;
           $merchent_name    = $verify_token['data']->name;
           $merchent_id = $verify_token['data']->user_id;

           $pay=new Recharge();
          $res= $pay->payment($card_number,$exp_month,$exp_year,$cvc,$merchent_name,$merchent_email);

//store transationinfo
 $sql="INSERT INTO transationinfo (transation_ID,transation_person_name, transation_person_email) VALUES ('$res','$merchent_name','$merchent_email')";
  $conn->query($sql);

         // update merchent balance
       $result="UPDATE merchant SET Balance=100 WHERE user_id='$merchent_id'";
       $conn->query($result);

          $response['message'] = 'transcation completed and update merchent balance successfully';
          $response['status']  = 200;
         print_r(json_encode($response));
            http_response_code(200);
       

        }
else{
  $response['message'] = 'Token is invalid';
  $response['status']  = 400;
  print_r(json_encode($response));
  http_response_code(400);
}

}
else{
  $response['message'] = 'Please enter Auth_key.';
  $response['status']  = 400;
  print_r(json_encode($response));
  http_response_code(400);

}
}
else{

  $response['message'] = 'Please enter required field.';
$response['status']  = 400;
print_r(json_encode($response));
http_response_code(400);
}
?>