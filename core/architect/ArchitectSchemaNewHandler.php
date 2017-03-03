<?php

function handleArchitectSchemaNew(){
  global $ASTRIA;
  
  if(!(ctype_alnum($_POST['newSchemaObject']))){
    die('Only letters and numbers allowed in Schema object name.');
  }
  $cleanObject=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['newSchemaObject']);
  
  //Check if table exists
  $result = Query("SHOW TABLES LIKE '".$cleanObject."'");
  $tableExists = count($result) > 0;
  
  //Check if history table exists
  $result = Query("SHOW TABLES LIKE 'History_".$cleanObject."'");
  $historyExists = count($result) > 0;

  if(
    ($tableExists==true)||
    ($historyExists==true)
  ){
    die('This schema already exists.');
  }
  
  Query("CREATE TABLE `".$cleanObject."` ( `".$cleanObject."ID` INT NOT NULL AUTO_INCREMENT , `UserInserted` INT NOT NULL , `TimeInserted` DATETIME NOT NULL , `UserUpdated` INT NULL , `TimeUpdated` DATETIME NULL , PRIMARY KEY (`".$cleanObject."ID`)) ENGINE = InnoDB;");
  
  if($_POST['newSchemaVersioning']=='yes'){
    Query(" CREATE TABLE `History_".$cleanObject."` ( `".$cleanObject."HistoryID` INT NOT NULL AUTO_INCREMENT ,`".$cleanObject."ID` INT NOT NULL, `UserInserted` INT NOT NULL , `TimeInserted` DATETIME NOT NULL , `UserUpdated` INT NULL , `TimeUpdated` DATETIME NULL , PRIMARY KEY (`".$cleanObject."HistoryID`)) ENGINE = InnoDB;");
  }
  
  header('Location: /architect/schema/'.$cleanObject);
  exit;
}
