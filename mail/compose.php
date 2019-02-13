<?php
/*
* Compse to Kindle
* Power by Kueiapp.com
* Autohr: Kuei App
* Copyright: Kuei App
*/
require_once(__DIR__.'/src/PHPMailer.php');
require_once(__DIR__.'/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// mb_language('ja');
mb_internal_encoding('UTF-8');
 
function composeToKindle($to, $title, $link, $data, $author){
// Make a complete HTML format
   $data = "<!DOCTYPE html>
   <html>
      <head>
         <meta charset='utf-8' />
         <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
         <meta content='utf-8' http-equiv='encoding'>
         <meta name='viewport' content='width=device-width,minimum-scale=1.0,initial-scale=1.0' />
         <meta http-equiv='X-UA-Compatible' content='IE=edge'>
         <title>{$title}</title>
      </head>
      <body><h3>Transfered by Kueiapp.com...</h3>{$data}</body>
   </html>";

// PHPMailer
   $message = "Your article:\n Title: $title\n Link: $link\n";
   $separator = md5(time());

   $email = new PHPMailer();
   $email->CharSet = 'UTF-8';
   $email->AddAddress($to);
   $email->AddAddress('{SECONDE_ADDRESS');
   $email->setFrom("support@kueiapp.com",$author); //Name is optional
   $email->Subject   = 'My Article to Kindle';
   $email->Body      = $message;  //HTML format
   $email->AddStringAttachment($data, $title.'.html', 'base64', 'text/html; charset=utf-8'); //Make attached file as utf-8

   if( $email->Send() ){
      echo "OK\n";
   }
   else{
      echo $email->ErrorInfo;
   }


}
