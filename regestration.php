<?Php
include"conn.php";
header('Access-Control-Allow-Origin: *');
$response = ['error' => true , 'message' => '' ,'status' => 200];
$pattren = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
 $input_data    = json_decode(file_get_contents("php://input"),true);

 if(!empty($input_data)) {

 $m_id       ="merchent-".rand(0,200);
 $m_name     = $input_data['name'];
 $m_email    = $input_data['email'];
 $m_password = MD5($input_data['password']);
 $m_company  = $input_data['company_name'];

 if(!empty($m_id ) && !empty($m_name) && !empty($m_email) && !empty($m_password) && !empty($m_company) ){
  if(preg_match($pattren,$m_email)){

$sql="INSERT INTO Merchant (user_id,name,email,password,Balance,Company_name)
VALUES (
'$m_id','$m_name','$m_email','$m_password','100','$m_company')";
if($conn->query($sql)){
  $response['message'] = 'Marchend added successfuly';
        $response['status']  = 200;
        print_r(json_encode($response));
        http_response_code(200);
} else {

  $response['message'] = 'Marchend not added ';
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