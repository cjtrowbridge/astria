<?php

function ArchitectSchemaElaborate(){
  global $ASTRIA;
  if(!(isset($ASTRIA['databases'][path(2)]))){
    die('Invalid Database Alias');
  }
  
  //TODO add listeners for csv dump flags
  
  
  TemplateBootstrap4('Schema: '.path(2),'ArchitectSchemaElaborateBodyCallback();',true);
}


function ArchitectSchemaElaborateBodyCallback(){
  global $ASTRIA;
  $Alias = path(2);
  $This = $ASTRIA['databases'][$Alias];
  
  switch($This['type']){
    case 'mysql':
      if(isset($_GET['query'])){
        include_once('MySQL.Query.php');
        ArchitectSchemaMySQLQuery($Alias);
        return;
      }
      switch(path(3)){
        case false:
          //list all tables and views
          include_once('MySQL.Database.Describe.php');
          MySQLDatabaseDescribe($Alias);
          break;
          
        case 'table':
          if(isset($_GET['new'])){ //Make a new table!
            include('MySQL.Table.New.php');
            MySQLTableNew($Alias);
            break;
          }
          //describe a table
          include_once('MySQL.Table.Describe.php');
          MySQLTableDescribe($Alias,path(4,false));
          break;
        
        case 'view':
          //describe a view
          break;
          
        default:
            echo '<p><b>Error:</b> Unsupported action: "'.path(3).'"</p>';
            break;
      }
      break;
    default:
      echo '<p>This database type is not supported by the schema tool. :[</p><p>Go build it! :]</p>';
      break;
  }
  
}
