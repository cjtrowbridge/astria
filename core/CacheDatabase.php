<?php

function CacheDatabaseDelete($hash){
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($hash))){return false;}
  die('not implemented');
  return true;
}
  
//TODO make the default cache database name a constant based on a config flag
function CacheDatabaseWrite($Hash,$Value,$Database = 'astria'){
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($hash))){return false;}
  
  $Hash    = mysqli_real_escape_string($ASTRIA['databases'][$Database]['resource'],$Hash);
  $Content = mysqli_real_escape_string($ASTRIA['databases'][$Database]['resource'],$Content);
  
  return Query(
    "
      INSERT INTO `Cache`(
        `Hash`, 
        `Content`, 
        `Created`, 
        `Expires`
      ) VALUES (
        '".$Hash."', 
        '".$Content."', 
        NOW(), 
        date_add(now(), INTERVAL 1 week)
      )
      ON DUPLICATE KEY UPDATE    
        `Hash`    = '".$Hash."', 
        `Content` = '".$Content."', 
        `Created` = NOW(), 
        `Expires` = date_add(now(), INTERVAL 1 week)
      ;
    ",
    $Database
  );

}

function CacheDatabaseRead($hash,$ttl = DISKCACHETTL){
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($hash))){return false;}
  
  $Hash    = mysqli_real_escape_string($ASTRIA['databases'][$Database]['resource'],$Hash);
  
  return Query(
    "SELECT * FROM Cache WHERE Hash LIKE '".$Hash."'",
    $Database
  );
  
}

function CacheDatabaseExists($hash){
 if(!(isValidMd5($hash))){return false;}
  die('not implemented');
  return true;
}

function CacheDatabaseCleanup(){
  die('not implemented');
}
