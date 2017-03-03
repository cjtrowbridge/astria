<?php

function CacheDatabaseDelete($Hash){
  global $ASTRIA;
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($Hash))){return false;}
  
  $Hash    = mysqli_real_escape_string($ASTRIA['databases'][$Database]['resource'],$Hash);
  
  return Query(
    "DELETE FROM `Cache` WHERE `Hash` LIKE '".$Hash."'",
    $Database
  );
  
  CacheDatabaseCleanup();
  
  return true;
}
  
//TODO make the default cache database name a constant based on a config flag
function CacheDatabaseWrite($Hash,$Content,$Database = 'astria'){
  global $ASTRIA;
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($Hash))){return false;}
  
  $Content=serialize($Content);
  
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

function CacheDatabaseRead($Hash,$TTL = CACHE_DATABASE_TTL,$Database = 'astria'){
  global $ASTRIA;
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($Hash))){return false;}
  
  $Hash    = mysqli_real_escape_string($ASTRIA['databases'][$Database]['resource'],$Hash);
  
  $SQL="SELECT Content FROM Cache WHERE Hash LIKE '".$Hash."' AND Created > '".date("Y-m-d H:i:s",(time()-$TTL))."' AND Expires > NOW()";
  pd($SQL);
  $Result=Query(
    $SQL,
    $Database
  );
  if(count($Result)==0){
    return false;
  }else{
    return unserialize($Result[0]['Content']);
  }
}

function CacheDatabaseExists($Hash){
 if(!(isValidMd5($Hash))){return false;}
  die('not implemented');
  return true;
}

function CacheDatabaseCleanup($Database = 'astria'){
  Query(
    "DELETE FROM `Cache` WHERE Expires < NOW()"
  );
}
