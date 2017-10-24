<?php

Hook('User Is Logged In - Before Presentation','SmartMailerRouting();');
function SmartMailerRouting(){
  if(path(0))=='smartmailer'){
    switch(path(1)){
      case false
        include_once('SmartMailer_Homepage.php');
        SmartMailer_Homepage();
        break;
    }
  }
}
