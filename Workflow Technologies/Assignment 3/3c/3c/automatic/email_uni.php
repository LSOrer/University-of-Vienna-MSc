<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';

header("Content-Type: application/json");
  
$email = $_REQUEST["email_recipient"];
$color = $_REQUEST["color"];

  $mail = new PHPMailer;
   
  $mail->isSMTP();
  $mail->Host = 'mail.univie.ac.at';
  $mail->SMTPDebug = 4;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'ssl';
  $mail->Username = 'a1250600';
  $mail->Password = '4O0mS=0sXU';
  $mail->Port = '465';
   
  $mail->addAddress($email);
  $mail->From = 'a01250600@unet.univie.ac.at';
  $mail->FromName = 'WT Email';
  //$mail->addAddress($_REQUEST['addr'], $_REQUEST['name']);
   
  $mail->WordWrap = 50;
  $mail->isHTML(true);
   
  $mail->Subject = "color order";
  
  $mail->Body = "This is a color order, please deliver 500g of ".$color." to the address: randomstreet 69/420 in 1337 Tschibuti";
   
  if (!$mail->send()) {
    $result_array["message"] = 'Failed';
    exit;
  } else {
	exit;
  }
?>