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
    global $ASTRIA;
    
    
    if(isset($ASTRIA['databases'][path(0)])){
      die('LETS ROUTE THIS SCHEMA OBJECT');
    }
  }
}
