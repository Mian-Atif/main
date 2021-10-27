<?php

  require 'vendor/autoload.php';
  use \Mailjet\Resources;

  //$db=include "conn.php";
  //$response = ['error' => true , 'message' => '' ,'status' => 200];
  
  \Stripe\Stripe::setApiKey(
    'sk_test_51Joui7L1cSJT1UwBVD0ZcLVt3xPFpSXmbA30b9EJDCizXEFSpy4oQ4sbiyg5hsAJ4oMtLfiARPMdejVTaL4pjVQr00LJQMDtcD'
  );
  class Recharge{ 
    
    public function payment($card_number,$exp_month,$exp_year,$cvc,$name,$email){
  $stripe = new \Stripe\StripeClient(
    'sk_test_51Joui7L1cSJT1UwBVD0ZcLVt3xPFpSXmbA30b9EJDCizXEFSpy4oQ4sbiyg5hsAJ4oMtLfiARPMdejVTaL4pjVQr00LJQMDtcD'
  );
  $token=$stripe->tokens->create([
    'card' => [
      'number' => $card_number,           //4242424242424242
      'exp_month' => $exp_month,         //10
      'exp_year' => $exp_year,         //2022
      'cvc' => $cvc,              //314
    ],
  ]);
  
  $customer=$stripe->customers->create([
    'source' => $token->id,
    'name' => $name,
    'email' => $email,

  ]);
  // print_r( $customer->id);

  $transation=$stripe->charges->create([
    'amount' => 2000,
    'currency' => 'usd',
    'customer' => $customer->id,
    'description' => 'My First Test Charge (created for API docs)',
  ]);
if($transation->captured){
  $transation_ID=$transation->id;
//updat merchent_balance
  // $result="UPDATE merchant SET Balance='100' WHERE user_id=$id";
  // $conn->query($result);
 
  // $sql="INSERT INTO transationinfo (transation_ID,transation_person_name, transation_person_email) VALUES ('$transation_ID','$name', '$email')";
  // $conn->query($sql);
  //echo  "success";
  return $transation_ID;
}
   }
}

?>