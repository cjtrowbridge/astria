<?php

function ArchitectSchemaElaborate(){
  global $ASTRIA;
  if(!(isset($ASTRIA['databases'][path(2)]))){
    die('Invalid Database Alias');
  }
  
  TemplateBootstrap4('SChema: '.path(2),'ArchitectSchemaElaborateBodyCallback();');
}


function ArchitectSchemaElaborateBodyCallback(){
  global $ASTRIA;
  $Alias = path(2);
  $This = $ASTRIA['databases'][$Alias];
  
  switch($This['type']){
    case 'mysql':
      switch(path(3)){
        case false:
          //list all tables and views
          $Tables = Query('SHOW TABLES',$Alias);
          echo ArrTabler($Tables);
          break;
          
        case 'table':
          //describe a table
          break;
          
        case 'view':
          //describe a view
          break;
          
        default:
            echo '<p><b>Error:</b> Unsupported action: "'.path(3).'"</p>';
            break;
      }
    default:
      echo '<p>This database type is not supported by the schema tool. :[</p><p>Go build it! :]</p>';
      break;
  }
  
}
