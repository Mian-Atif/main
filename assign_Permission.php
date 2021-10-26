<?php
include"conn.php";
header('Access-Control-Allow-Origin: *');
$response = ['error' => true , 'message' => '' ,'status' => 200];
//$email_pattren = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
//$name_pattern = "/^[a-zA-Z]+$/";
$input_data = json_decode(file_get_contents("php://input"),true);

if(!empty($input_data))
{
    $u_name=$input_data['name'];
    $p_name=$input_data['permission_name'];

    $comp="SELECT user_id FROM user WHERE name ='$u_name'";
    $comp1=$conn->query($comp);
    
    if($comp1->num_rows>0){
    $comp3=$comp1->fetch_assoc();
   $data1= $comp3['user_id'];
  
    }
    else{
        $response['message'] = ' Not found this user.';
        $response['status']  = 400;
        print_r(json_encode($response));
        http_response_code(400);
        
    }

  $rol="SELECT permission_id FROM Permission WHERE permission_name ='$p_name'";
    $rol1=$conn->query($rol);
   if($rol1->num_rows>0){
    $rol3=$rol1->fetch_assoc();
   $data= $rol3['permission_id'];
    }
    else{

        $response['message'] = ' Not found this permission_id.';
        $response['status']  = 400;
        print_r(json_encode($response));
        http_response_code(400);
    
    }
    if(!empty($data)&&!empty($data1)){
    $ac="INSERT INTO User_Permission (user_id,permission_id) VALUES ('$data1','$data')";
    if ($conn->query($ac) === TRUE) 
    $response['message'] = 'Data insert successfuly.';
    $response['status']  = 200;
    print_r(json_encode($response));
    http_response_code(200);
}
    else{
        $response['message'] = 'Data not inserted.';
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