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
    $Table  = Sanitize(path(1,false));
    $Key    = Sanitize(path(2,false));
    
    if(isset($ASTRIA['databases'][$Schema])){
      
      if(HasPermission('View_Schema_'.$Schema)){
        
        if($Table==false){
            //User is navigating at the schema level and has view permission.
          
            Event('SchemaRouter: View_Schema_'.$Schema);
            SchemaRouterEndpointBuilder($Schema, $Table);
        
        }else{
            //User is navigating at the table level. Permission Unclear
          
            if(HasPermission('View_Schema_'.$Schema.'_View_Table_'.$Table)){
              //User is navigating at the table level and has view permission.
              
              Event('SchemaRouter: View_Schema_'.$Schema.'_View_Table_'.$Table);
              SchemaRouterEndpointBuilder($Schema, $Table);
              
            }else{
                Event('SchemaRouter: Permission Denied to View Table');
                die('Permission denied to view table '.$Table.' in Schema '.$Schema.'.'); //TODO make this more pretty
            }
        }
      }else{
        Event('SchemaRouter: Permission Denied to View Schema');
        die('Permission denied to view schema '.$Schema.'.'); //TODO make this more pretty
      }
      
    }
  }
}

function SchemaRouterEndpointBuilder($Schema = false, $Table = false){
  //make the page
  include_once('SchemaRouterPageBuilder.php');
  $Page = SchemaRouterPageBuilder($Schema, $Table);
  
  //try to save the page with hook
  
  //display the page
  echo $Page;
}
