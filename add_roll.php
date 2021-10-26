<?php
include"conn.php";
header('Access-Control-Allow-Origin: *');
$response = ['error' => true , 'message' => '' ,'status' => 200];
$input_data    = json_decode(file_get_contents("php://input"),true);

 if(!empty($input_data)) {

 $rol_id     ="roll-".rand(0,200);
 $rol_name   = $input_data['roll_name'];

 if(!empty($rol_id ) && !empty($rol_name)){
    $sql="INSERT INTO roles (roll_id,roll_name) VALUES ('$rol_id','$rol_name')";
    if($conn->query($sql)){
      $response['message'] = 'roll added successfuly';
            $response['status']  = 200;
            print_r(json_encode($response));
            http_response_code(200);
    } 
    else {
      $response['message'] = 'roll not added ';
      $response['status']  = 510;
      print_r(json_encode($response));
      http_response_code(510);
        }
 }
else{
    $response['message'] = 'please enter all field.';
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