<?php

function handleArchitectSchemaNew(){
  
  if(!(ctype_alnum($_POST['newSchemaObject']))){
    die('Only letters and numbers allowed in Schema object name.');
  }
  
  //Check if table exists
  $result = Query("SHOW TABLES LIKE '".mysqli_real_escape_string($_POST['newSchemaObject'])."'");
  $tableExists = count($result) > 0;
  
  //Check if history table exists
  $result = Query("SHOW TABLES LIKE '".mysqli_real_escape_string($_POST['newSchemaObject'])."_History'");
  $historyExists = count($result) > 0;

  if(
    ($tableExists==true)||
    ($historyExists==true)
  ){
    die('This schema already exists.');
  }
  echo 'ok';
  
  
  exit;
}
