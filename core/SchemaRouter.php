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
    
    $Schema = Sanitize(path(0));
    $Table  = Sanitize(path(1));
    $Key    = Sanitize(path(2));
    
    if(isset($ASTRIA['databases'][$Schema])){
      
      if(HasPermission('View_Schema_'$Schema)){
        
        switch($Table){
          //my thinking is that this will later be able to handle inserts and updates
          case false;
            die('Show list of tables');
            break;
          default:
            
            if(HasPermission('View_Schema_'$Schema.'_View_Table_'.$Table)){
              die('Let\'s look at the table '.$Table.' in schema '.$Schema);
            }else{
              die('Permission denied to view table '.$Table.' in Schema '.$Schema.'.'); //TODO make this more pretty and allow hooks for alternate page
            }
            
            break;
        }
        
      }else{
        die('Permission denied to view schema '.$Schema.'.'); //TODO make this more pretty and allow hooks for alternate page
      }
      
    }
  }
}
