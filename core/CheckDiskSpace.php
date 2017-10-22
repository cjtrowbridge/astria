<?php

Hook('Hourly Webhook','CheckDiskSpace();');

function CheckDiskSpace(){
  if(disk_free_space('/')<(1e+9)){
    $message = '<h1>'.$ASTRIA['app']['appName'].': WARNING!</h1><p>Less than one GB of disk is available!</p>';
    $subject = $ASTRIA['app']['appName'].': WARNING!';
    $to      = $ASTRIA['smtp']['adminEmail'];
    if($to==''){
      $to='root@localhost';
    }
    SendEmail($message, $subject, $to);
  }
}
