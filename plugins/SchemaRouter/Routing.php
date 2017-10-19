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
    //Include this so the templates can call it
    include_once('SchemaRouterPageField.php');
    
    global $ASTRIA;
    
    $Schema = Sanitize(path(0));
    $Table  = Sanitize(path(1,false));
    $Key    = Sanitize(path(2,false));
    
    if(isset($ASTRIA['databases'][$Schema])){
      
      if(HasPermission('SchemaRouter_Schema_'.$Schema)){
        
        if($Table==false){
            //User is navigating at the schema level and has view permission.
          
            Event('SchemaRouter_Schema_'.$Schema);
            include_once('SchemaRouterPageBuilder.php');
            SchemaRouterPageBuilder($Schema);
        
        }else{
            //User is navigating at the table level. Permission Unclear
          
            if(HasPermission('SchemaRouter_Schema_'.$Schema.'_Table_'.$Table)){
              //User is navigating at the table level and has view permission.
              
              Event('SchemaRouter_Schema_'.$Schema.'_Table_'.$Table);
              include_once('SchemaRouterPageBuilder.php');
              SchemaRouterPageBuilder($Schema, $Table);
              
            }else{
                Event('SchemaRouter: Permission Denied to View Table');
                die('Permission denied to view table '.$Table.' in Schema '.$Schema.'.'); //TODO make this more pretty
            }
        }
      }else{
        Event('SchemaRouter: Permission Denied to View Schema');
        die('Permission denied to view schema '.$Schema.'.'); //TODO make this more pretty
      }
      
    }else{Event('SchemaRouter: No schema match detected.');}
  }
}
