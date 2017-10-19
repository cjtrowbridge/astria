<?php

Hook('User Is Logged In - Presentation','SchemaRouter();');
Hook('User Is Logged In - Before Presentation','LoadCachedSchemaPages();');

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
    
    $Schema = SchemaRoute('Schema');
    $Table  = SchemaRoute('Table');
    $Key    = SchemaRoute('Key');
    
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

function LoadCachedSchemaPages(){ 
  if($handle = opendir('plugins/SchemaRouter/cache')){
    while (false !== ($class = readdir($handle))){
      $include_path='plugins/SchemaRouter/cache/'.$class;
      if((!(strpos($class,'.php')===false)) && $class != "." && $class != ".." && file_exists($include_path)){
        Event('Before Loading SchemaRouter cache file: '.$include_path);
        include_once($include_path);
        Event('After Loading SchemaRouter cache file: '.$include_path);
      }
    }
    closedir($handle);
  } 
}

function SchemaRoute($Query = false){
  switch($Query){
    case 'Schema':
    case 'schema':
      return Sanitize(path(0));;
    case 'Table':
    case 'table':
      return Sanitize(path(1,false));
    case 'Key':
    case 'key':
      return intval(path(2));
    default:
      return array(
        'Schema' => Sanitize(path(0)),
        'Table'  => Sanitize(path(1,false)),
        'Key'    => intval(path(2))
      );
  }
 

  
  
