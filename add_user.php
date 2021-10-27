<?php

include "conn.php";
include "send_mail.php";
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

           $merchent_email   = $verify_token['data']->email;
           $merchent_company = $verify_token['data']->Company_name;
           $merchent_id = $verify_token['data']->user_id;
           $marchent_balance=$verify_token['data']->Balance;
           $var=10;
           $update=$marchent_balance-$var;
          // var_dump($merchent_email);
            //exit;

          //  echo $mail;
          //  echo $company;
          //  echo 'hy';
          //  exit;
                if(!empty($input_data))
                {
                  //  var_dump($input_data);

                        $user_name    =$input_data['name'];
                        $user_email   = $input_data['email'];
                        $user_pass    = $input_data['password'];
                        $user_id      = "user-".rand(0,200);
                      
                        //echo ($val3['email']);
                        //echo $val3['email'];
                        //echo $user_email;
                        

                        if(!empty($user_email) && !empty($user_pass)){
                          //  if(preg_mvatch($name_pattern,$user_fname) ){

                                if(preg_match($email_pattren,$user_email)){



                        $sql="INSERT INTO user (name,email, password,user_id,Company_name)
                        VALUES ('$user_name','$user_email', '$user_pass','$user_id','$merchent_company')";

//auto send mail and password to sub user

                        if($conn->query($sql)){
                          $mailSend = new Email();

                          if($marchent_balance>10){

                          $sub ="Welcome to PF";
                          $body = "Hi $user_name, You are added to  $merchent_company. Here is your login detail. Email:  $user_email  Password: $user_pass";
                        $rs= $mailSend->sendMail($merchent_email, $user_email,"Cc@gmail.com","BCc@gmail.com",$sub,$body);
                          
                  
                        
          
                      //   //response save in mail table
                        $mail="INSERT INTO mailinfo (user_id,mail_from,mail_to,cc,Bcc,mail_subject,body) VALUES ('$merchent_id','muhammadatifrizwan@gmail.com','$user_email','','','$sub','$body')";
                        $conn->query($mail);

                        

                        $result="UPDATE merchant SET Balance='$update' WHERE user_id='$merchent_id'";
                        $conn->query($result);

                            $response['message'] = 'sub user add successfuly!.';
                            $response['status']  = 200;
                            print_r(json_encode($response));
                            http_response_code(200);
                        }
                        else{
                          $response['message'] = 'recharge your balance.';
                          $response['status']  = 200;
                          print_r(json_encode($response));
                          http_response_code(200);


                        }
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
      $response['message'] = 'Must fill all  field.';
      $response['status']  = 400;
      print_r(json_encode($response));
      http_response_code(400);}

  }
else{

    $response['message'] = 'Please enter required field.';
    $response['status']  = 400;
  print_r(json_encode($response));
  http_response_code(400);
}

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
?>