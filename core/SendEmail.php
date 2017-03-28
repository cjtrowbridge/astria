<?php

function SendEmail($message, $subject = DEFAULT_EMAIL_SUBJECT, $to, $from = DEFAULT_EMAIL_FROM){
  
  $mail = new PHPMailer;
  global $SMTP_DEBUG_LEVEL;
  $mail->isSMTP();
  $mail->SMTPSecure = 'tls';
  //$mail->SMTPSecure = 'ssl';
  //$mail->SMTPAuth = true;
  $mail->SMTPAuth = false;
  $mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
  $mail->SMTPDebug = SMTP_DEBUG_LEVEL;
  $mail->Debugoutput = 'html';
  $mail->Host = SMPT_HOSTNAME;
  $mail->Port = SMPT_PORT;
  //$mail->Username = SMTP_USERNAME;
  //$mail->Password = SMTP_PASSWORD;
  $mail->setFrom($from, APPNAME);
  $mail->addReplyTo($from, APPNAME);
  $to=explode(",",$to);
  foreach($to as $sendto){
    if(!(trim($sendto)=='')){
      $mail->addAddress($sendto);
    }
	}
  $mail->addAddress(DEFAULT_EMAIL_FROM);
  $mail->Subject = $subject;
  $mail->msgHTML($message, dirname(__FILE__));
  if(!$mail->send()){
    if(!($silent)){
     echo "Mailer Error: " . $mail->ErrorInfo;
    }
  }else{
    //echo "Message sent!";
  }
  
}
