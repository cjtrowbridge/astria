<?php

function ArchitectSchemaElaborate(){
  global $ASTRIA;
  if(!(isset($ASTRIA['databases'][path(2)]))){
    die('Invalid Database Alias');
  }
  
  //TODO add listeners for csv dump flags
  
  global $ASTRIA;
  $Alias = path(2);
  $This = $ASTRIA['databases'][$Alias];
  
  switch($This['type']){
    case 'mysql':
      switch(path(3)){
        case false:
          //Database handlers
          
          break;
          
        case 'table':
          $Table = path(4,false);
          if(!(IsValidTable($Table,$Alias))){
            die('Invalid Table: '.$Table);
          }
          
          //DO a CSV dump of the table. Note, this needs to handle large tables
          if(
            isset($_GET['csv'])
          ){
            include_once('MySQL.Table.CSV.php');
            MySQLTableCSV($Alias,$Table);
            break;
          }
          
          //Drop the table
          if(isset($_POST['drop'])){
            if($_POST['drop']=='drop'){
              include_once('MySQL.Table.Drop.php');
              MySQLTableDropConfirmed($Alias,$Table);
            }else{
              die('You did not type "drop" into the box.');
            }
            break;
          }
          
          //Truncate the table
          if(isset($_POST['truncate'])){
            if($_POST['truncate']=='truncate'){
              include_once('MySQL.Table.Truncate.php');
              MySQLTableTruncateConfirmed($Alias,$Table);
            }else{
              die('You did not type "truncate" into the box.');
            }
            break;
          }
          
          //DO a CSV dump of the table. Note, this needs to handle large tables
          if(
            isset($_GET['new'])&&
            isset($_POST['newTableName'])
          ){
            include_once('MySQL.Table.New.Handler.php');
            MySQLTableNewHandler($Alias);
            header('Location: /architect/schema/'.$Alias);
            exit;
            break;
          }
          
          break;
        
        case 'view':
          //View handlers
          break;
          
        default:
            //Nothing to handle
            break;
      }
      break;
    default:
      break;
  }
  
  
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
          $Table = path(4,false);
          if(!(IsValidTable($Table,$Alias))){
            die('Invalid Table: '.$Table);
          }
          
          //Make a new table!
          if(isset($_GET['new'])){ 
            include_once('MySQL.Table.New.php');
            MySQLTableNew($Alias);
            break;
          }
         
          //Drop the table
          if(isset($_GET['drop'])){
            include_once('MySQL.Table.Drop.php');
            MySQLTableDrop($Alias,$Table);
            break;
          }
          
          //Truncate the table
          if(isset($_GET['truncate'])){
            include_once('MySQL.Table.Truncate.php');
            MySQLTableTruncate($Alias,$Table);
            break;
          }
          
          //Describe a table
          include_once('MySQL.Table.Describe.php');
          MySQLTableDescribe($Alias,$Table);
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
