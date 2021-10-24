<?php
include"conn.php";
header('Access-Control-Allow-Origin: *');
$response = ['error' => true , 'message' => '' ,'status' => 200];
$pattren = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
$input_data = json_decode(file_get_contents("php://input"),true);
if(!empty($input_data)) {

   $user_email = $input_data['email'];
    $user_pass  = $input_data['password'];

      if(!empty($user_email ) && !empty($user_pass)){

        if(preg_match($pattren,$user_email)){

              //var_dump($response);
              //"select * from users where email = '$email' and password ='$password' LIMIT 1 "
              $sql="SELECT * FROM  user WHERE (email = '$user_email' AND password = '$user_pass') LIMIT 1";
              //$data=[];   
              $data=$conn->query($sql);
              // var_dump($data);
           if($data->num_rows > 0){
               $id=$data->fetch_assoc();
               $user_id=$id['user_id'];
               $token='token-'.rand(0,200);
              // $row=$data->fetch_ass;oc()
               // echo json_encode( "email=" . $row["email"]. " pass=" . $row["pass"]);
               $conn->query("INSERT INTO access_token (user_id,token) VALUES ('$user_id','$token')");
               $sql="SELECT token FROM  access_token WHERE (user_ID = '$user_id') limit 1 ";
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