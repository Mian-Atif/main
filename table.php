<?php
include 'conn.php';

//sql to create table for  detail 

$merchant="CREATE TABLE Merchant (
  id            INT(55) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id         VARCHAR(255) NOT NULL,
name            VARCHAR(50) NOT NULL,
email           VARCHAR(60) NOT NULL,
password        VARCHAR(225) NOT NULL,
Balance         VARCHAR(255) NOT NULL,
Company_name    VARCHAR(50) NOT NULL  
)";

$sql="CREATE TABLE user (
  id            INT(55) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id         VARCHAR(255) NOT NULL,
name            VARCHAR(50) NOT NULL,
email           VARCHAR(60) NOT NULL,
password        VARCHAR(225) NOT NULL,
Company_name    VARCHAR(50) NOT NULL  
)";

// sql to create table for Roles detail 
$user= "CREATE TABLE Roles (
  id            INT(55) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
roll_id          VARCHAR(55) NOT NULL,
roll_name        VARCHAR(50) NOT NULL
)";

$pivat="CREATE TABLE User_Roles (
  id              INT(55)  UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id          varchar(50) NOT NULL,
  roll_id          VARCHAR(50) NOT NULL
  )";
   
   $pro= "CREATE TABLE Permission (
    id            INT(55) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  permission_id          VARCHAR(55) NOT NULL,
  permission_name        VARCHAR(50) NOT NULL
  )";

$pivat1="CREATE TABLE User_Permission (
  id              INT(55)  UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id          varchar(50) NOT NULL,
  permission_id          VARCHAR(50) NOT NULL
  )";
   
   $mail="CREATE TABLE mailinfo (
    id            INT(55) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id         VARCHAR(255) NOT NULL,
  mail_from            VARCHAR(50) NOT NULL,
  mail_to         VARCHAR(60) NOT NULL,
  cc        VARCHAR(225)  NULL,
  bbc         VARCHAR(255) NULL,
  mailsubject    VARCHAR(50) NOT NULL,  
  body    VARCHAR(255) NOT NULL  

  )";
  $pay="CREATE TABLE transationinfo (
  id                             INT(55) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  transation_ID                  VARCHAR(255) NOT NULL,
  transation_person_name         VARCHAR(50) NOT NULL,
  transation_person_email        VARCHAR(60) NOT NULL
  )";
   
   

if ($conn->query($merchant) === TRUE &&$conn->query($sql) === TRUE && $conn->query($user) === TRUE && $conn->query($pivat) === TRUE && $conn->query($pro) === TRUE && $conn->query($pivat1) === TRUE && $conn->query($mail) === TRUE && $conn->query($pay) === TRUE ) {
    echo "Table created successfully";
  } 
  else {
    echo "Error while creating table: " . $conn->error;
  }
?>