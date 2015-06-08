<?php
/*$to       = 'purnenduroy07@gmail.com';
$subject  = 'Testing sendmail.exe';
$message  = 'Hi, you just received an email using sendmail!';
$headers  = 'From: shanoo.roy@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
if(mail($to, $subject, $message, $headers))
    echo "Email sent";
else
    echo "Email sending failed";*/

ini_set('SMTP','ssl:smtp.gmail.com' );
ini_set('smtp_port','465');
ini_set('sendmail_from', 'shanoo.roy@gmail.com');          
$to = 'purnenduroy07@gmail';
$subject = 'Test mail';
$message = 'Hello! This is a simple email message.';
$from = 'shanoo.roy@gmail.com';
$headers = 'From:' . $from;
$retval = mail($to,$subject,$message,$headers);
   if( $retval == true )  
   {
      echo "Message sent successfully...";
   }
   else
   {
      echo "Message could not be sent...";
   }
?>