<?php
include"conn.php";
header('Access-Control-Allow-Origin: *');

class Home{
    public $m_id;
    public $m_name; 
    public $m_email;
    public $m_balance;
    public $m_company;

 public function account() {

         $sql="SELECT * FROM  Merchant ;
               $data=$conn->query($sql);
            
           if($data->num_rows > 0) {
               $row=$data->fetch_assoc();
              $m_id=$row['user_id'];
              $m_name=$row['name'];
              $m_email=$row['email'];
              $m_balance=$row['Balance'];
              $m_company=$row['Company_name'];
 }
}
}

?>