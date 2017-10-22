<?php

function SendEmail($message, $subject = null, $to, $from = null){
  global $ASTRIA;
  if($subject==null){$subject = $ASTRIA['app']['appName'];}
  if($from==null){$from = $ASTRIA['smtp']['defaultEmailFrom'];}
  
  include_once('core/PHPMailer/PHPMailer.php');
  include_once('core/PHPMailer/PHPMailerSMTP.php');
	
  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->SMTPSecure = 'tls';
  //$mail->SMTPSecure = 'ssl';
  //$mail->SMTPAuth = true;
  $mail->SMTPAuth = false;
  $mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
  $mail->SMTPDebug = $ASTRIA['smtp']['PHPMailerDebuggingFlag'];
  $mail->Debugoutput = 'html';
  $mail->Host = $ASTRIA['smtp']['host'];
  $mail->Port = $ASTRIA['smtp']['port'];
  //$mail->Username = $ASTRIA['smtp']['username'];
  //$mail->Password = $ASTRIA['smtp']['password'];
  $mail->setFrom($from, $ASTRIA['app']['appName']);
  $mail->addReplyTo($from, $ASTRIA['app']['appName']);
  $to=explode(",",$to);
  foreach($to as $sendto){
    if(!(trim($sendto)=='')){
      $mail->addAddress($sendto);
    }
	}
  $mail->addAddress($ASTRIA['smtp']['defaultEmailFrom']);
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
