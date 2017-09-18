<?php

function MySQLTableNewHandler($Alias){
  if(isset($_POST['newTableName'])){
    $_GET['verbose'] = '';
    pd($_POST);
    //TODO validate $_POST['newTableName']
    $SQL="
      CREATE TABLE `".$_POST['newTableName']."` (
        `".$_POST['newTableName']."ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        
    ";
    
    if(
      isset($_GET['commonColumnNameVarchar255'])
    ){
      if($_GET['commonColumnNameVarchar255']=='true'){
        $SQL.="
          `Name` varchar(255) DEFAULT NULL,";
      }else{Event('commonColumnNameVarchar255 was checked but did not match');}
    }else{Event('User did not check commonColumnNameVarchar255');}
    
    if(isset($_GET['commonColumnDescriptionText'])){
      if($_GET['commonColumnDescriptionText']=='true'){
        $SQL.="
          `Description` text,";
      }else{Event('commonColumnDescriptionText was checked but did not match');}
    }else{Event('User did not check commonColumnDescriptionText');}
    
    
    //Remove Any Leading Comma If Present
    $SQL=rtrim($SQL,',');
    
    $SQL.="
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    pd($SQL);
    Query($SQL,$Alias);
    
    
    exit;
  }
}
