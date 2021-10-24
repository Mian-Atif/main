<?php
include"conn.php";
header('Access-Control-Allow-Origin: *');
$response = ['error' => true , 'message' => '' ,'status' => 200];
$pattren = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
$input_data = json_decode(file_get_contents("php://input"),true);
if(!empty($input_data)) {

   $m_email = $input_data['email'];
    $m_password  = MD5($input_data['password']);
    //echo $m_password;
    //exit();

      if(!empty($m_email ) && !empty($m_password)){

        if(preg_match($pattren,$m_email)){

              //var_dump($response);
              //"select * from users where email = '$email' and password ='$password' LIMIT 1 "
              $sql="SELECT * FROM  Merchant WHERE (email = '$m_email' AND password = '$m_password')  limit 1";
             // $data=[];   
              $data=$conn->query($sql);
            //   var_dump($data);
           if($data->field_count > 0){
               $row=$data->fetch_assoc();
             //  echo "$row";
              $merchant_id=$row['user_id'];
               $token='token-'.rand(50,200);
               $conn->query("INSERT INTO access_token (user_id,token) VALUES ('$merchant_id','$token')");
               $sql="SELECT token FROM  access_token WHERE (user_ID = '$merchant_id') limit 1 ";
               $token=$conn->query($sql);  
               $login_token=$token->fetch_assoc();
               $response["token"]=$login_token['token'];
               $response["message"]="login successfully";
                    print_r( json_encode($response));
                    http_response_code(200);
                                      }
             else{
                           $response['message'] = 'email not exist!';
                          $response['status']  = 510;
                          print_r(json_encode($response));
                          http_response_code(510);
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