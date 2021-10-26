<?php
  require 'vendor/autoload.php';
  use \Mailjet\Resources;
  $response = ['error' => true , 'message' => '' ,'status' => 200];

  class Email{

    public function sendMail($from,$to,$cc,$bcc,$subject,$body){
      
          $mj = new \Mailjet\Client('efa0293f23eb7fc2d3ac845c5fe16674','463dcaa173468e8cf24b660ee649a7f1',true,['version' => 'v3.1']);
          $body = [
            'Messages' => [
              [
                'From' => [
                  'Email' => $from,
                  'Name' => ""
                ],
                'To' => [
                  [
                    'Email' =>$to,
                    'Name' => ""
                  ]
                ],
                'Cc' => [
                    [
                      'Email' => $cc,
                      'Name' => ""
                    ]
                  ],
                  'Bcc' => [
                    [

                      'Email' =>$bcc,
                      'Name' => ""
                    ]
                  ],
                'Subject' =>$subject,
                'TextPart' => $body,
                'HTMLPart' => "",
                'CustomID' => ""
              ]
            ]
          ];
          $res =$mj->post(Resources::$Email, ['body' => $body]);
          $res->success() && var_dump($res->getData());

          if( $res->success()==true){
            $response['message'] = 'Mail send successfuly.';
             $response['status']  = 200;
            print_r(json_encode($response));
            http_response_code(200);
                }
          else{
            $response['message'] = 'Mail not send successfuly.';
            $response['status']  = 200;
           print_r(json_encode($response));
           http_response_code(200);
          }
  }
}
?>