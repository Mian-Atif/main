<?php
require './vendor/autoload.php';
use \Firebase\JWT\JWT;
require_once 'verification.php';
include"conn.php";

header('Access-Control-Allow-Origin: *');
$response = ['error' => true , 'message' => '' ,"jwt"=>'','status' => 200];
$pattren = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
$input_data = json_decode(file_get_contents("php://input"),true);



if(!empty($input_data)) {

   $m_email = $input_data['email'];
   $m_password  = MD5($input_data['password']);

    

      if(!empty($m_email ) && !empty($m_password)){

        if(preg_match($pattren,$m_email)){

              //var_dump($response);
              //"select * from users where email = '$email' and password ='$password' LIMIT 1 "
              $sql="SELECT * FROM  Merchant WHERE (email = '$m_email' AND password = '$m_password')  limit 1";
             // $data=[];   
              $data=$conn->query($sql);
            //   var_dump($data);
           if($data->num_rows > 0){
               $row=$data->fetch_assoc();
             //  murchend account\
              //$merchant_id=$row['user_id'];

              // $merchant_email=$row['email'];
              // $merchant_password=$row['password'];


              //jwt token function call 
              $verification = new Verification();
              $user_type = "merchant";
              $verification_data=$verification->createToken( $row,$user_type);

 

              if($verification_data['status'])

              {    
                $response['message'] = 'login successfully.'; 
                $response['jwt']  = $verification_data['Token'];
                //$response['status']  = 200;
                print_r(json_encode($response));
                  http_response_code(200);

                   //set_response($verification_data['Token'],"use this data in your header!",200);      

              }else{

                  set_response(null,"server problem please try again",500);

                  

              }

              //if($m_email==$merchant_email && $m_password==$merchant_password)
              // $m_name=$row['name'];
              // $m_email=$row['email'];
              // $m_balance=$row['Balance'];
              // $m_company=$row['Company_name'];

              // echo ($merchant_id.PHP_EOL.$m_name.PHP_EOL.$m_email.PHP_EOL.$m_balance.PHP_EOL.$m_company.PHP_EOL);

              //  $token='token-'.rand(50,200);
              //  $conn->query("INSERT INTO access_token (user_id,token) VALUES ('$merchant_id','$token')");
              //  $sql="SELECT token FROM  access_token WHERE (user_ID = '$merchant_id') limit 1 ";
              //  $token=$conn->query($sql);  
              //  $login_token=$token->fetch_assoc();

// $iss="localhost";
// $iat=time();

// $nbf=$iat + 10;

// $exp=$iat + 30;

// $aud="myuser";

// $user_arr_data=[];

// //"id"=>$user_data['id'],
// $user_arr_data['name']=$m_email;
// $user_arr_data['email']=$m_password;


// $secret_key="owt125";

// $payload_info=array(

// "iss"=>$iss,
// "lat"=>$iat,
// "nbf"=>$nbf,
// "exp"=>$exp,
// "aud"=>$aud,
// "data"=>$user_arr_data
// );



//             $jwt= JWT::encode($payload_info, $secret_key, 'HS512');

//echo $jwt;
           // $response["jwt"]=$jwt;
            // $response["message"]="login successfully";
            //         print_r( json_encode($response));
            //         http_response_code(200);
            //                           }
            //  else{
            //                $response['message'] = 'email not exist!';
            //               $response['status']  = 510;
            //               print_r(json_encode($response));
            //               http_response_code(510);
            //             }
            }
                    }
                    
         else{
                  $response['message'] = 'Email format invalid!.';
                   $response['status']  = 404;
                    print_r(json_encode($response));
                     http_response_code(404);

                    }
       }

      else{
        $response['message'] = 'Enter email and password field.';
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