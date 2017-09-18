<?php

function MySQLTableNewHandler(){
  if(isset($_POST['newTableName'])){
    pd($_POST);
    exit;
  }
}
