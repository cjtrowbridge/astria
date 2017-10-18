<?php

Hook('User Is Logged In - Presentation','SchemaRouter();');

function SchemaRouter(){
  if(
    !IsWaiting() &&
    path(0)&&
    path(0)!='astria'&&
    path(0)!='architect'&&
    path(0)!='css'&&
    path(0)!='img'&&
    path(0)!='js'
  ){
    $Schema=path(0);
    if(isset($ASTRIA['databases'][$Schema])){
      $Permission = $Schema;
      if(HasPermission($Permission)){
        die('YOur wish is my command.');
      }else{
        die('Permission denied.');//TODO make this more pretty and allow hooks for alternate page
      }
    }
  }
}
