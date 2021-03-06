<?php

function MySQLTableColumnAddHandler($Alias){
  if(isset($_POST['newColumnName'])){
    $Table = path(4,false);
    if(!(IsValidTable($Table,$Alias))){
      $Table = false;
      die('Invalid Table');
    }
    
    pd($_POST);
    exit;
    
    $SQL="
      CREATE TABLE `".$_POST['newTableName']."` (
        `".$_POST['newTableName']."ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
    
    if(isset($_POST['commonColumnNameVarchar255'])&&($_POST['commonColumnNameVarchar255']=='true')){
      $SQL.="
        `Name` varchar(255) DEFAULT NULL,";
    }
      
    if(isset($_POST['commonColumnDescriptionText'])&&($_POST['commonColumnDescriptionText']=='true')){
      $SQL.="
        `Description` text,";
    }
    
    //Remove Any Leading Comma If Present
    $SQL=rtrim($SQL,',');
    
    $SQL.="
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    Query($SQL,$Alias);
    
    header('Location: /architect/schema/'.$Alias.'/table/'.$_POST['newTableName']);
    
    exit;
  }
}
