<?php

include"conn.php";
header('Access-Control-Allow-Origin: *','token');
$response = ['error' => true , 'message' => '' ,'status' => 200];
$email_pattren = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
//$name_pattern = "/^[a-zA-Z]+$/";
$input_data = json_decode(file_get_contents("php://input"),true);
if(!empty($input_data))
{
  //  var_dump($input_data);
  $m_email='muhammadatifrizwan@gmail.com';

     $comp="SELECT * FROM Merchant WHERE (email='$m_email')";
        $comp1=$conn->query($comp);
       // var_dump($comp1);
        //exit();
        if($comp1->num_rows>0){
        $comp3=$comp1->fetch_assoc();
        
        }
        else{
           echo "not found";
        }
        $user_name    =$input_data['name'];
        $user_email   = $input_data['email'];
        $user_pass    = $input_data['password'];
        $user_company = $comp3['Company_name'];
        $user_id='user-'.rand(0,200);
        $val= "SELECT email FROM Mercahant where email='$user_email'";
         $val2=$conn->query($val);
       // var_dump($val2);
        if($val2 === true){
            $val3=$val2->fetch_assoc();
        }
        else{
            $val3['email']=null;
        }
       
        //echo ($val3['email']);
        //echo $val3['email'];
        //echo $user_email;
        
        if(!$user_email==$val3['email']){

        if(!empty($user_email) && !empty($user_pass)){
          //  if(preg_mvatch($name_pattern,$user_fname) ){

                if(preg_match($email_pattren,$user_email)){
        
        $sql="INSERT INTO user (name,email, password,user_id,Company_name)
        VALUES ('$user_name','$user_email', '$user_pass','$user_id','$user_company')";

        if($conn->query($sql)){
            echo 6;
            $response['message'] = 'sub user add successfuly!.';
            $response['status']  = 200;
         print_r(json_encode($response));
         http_response_code(200);
      }      
}
else{
    $response['message'] = 'Email format invalid!.';
    $response['status']  = 404;
     print_r(json_encode($response));
      http_response_code(404);


}
            
            // }
            // else{
            //     $response['message'] = 'contain non alphabet.';
            //     $response['status']  = 400;
            //     print_r(json_encode($response));
            //     http_response_code(400);}
    }
        
else{
    $response['message'] = 'Must fill all  field.';
    $response['status']  = 400;
    print_r(json_encode($response));
    http_response_code(400);}
}
else {
    $response['message'] = 'sub user alredy exit!.';
    $response['status']  = 510;
      print_r(json_encode($response));
      http_response_code(510);

    }
}
else{

    $response['message'] = 'Please enter required field.';
  $response['status']  = 400;
  print_r(json_encode($response));
  http_response_code(400);
}
?>