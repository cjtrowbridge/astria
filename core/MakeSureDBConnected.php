<?php

function MakeSureDBConnected($Database='astria core administrative database'){

  global $ASTRIA;

  if(!(isset($ASTRIA['databases'][$Database]))){die("Database configuration not found for '".$Database."'. Please add to config.php.");}

  if($ASTRIA['databases'][$Database]['resource']==false){
    switch($ASTRIA['databases'][$Database]['type']){
      case 'mysql':
        $ASTRIA['databases'][$Database]['resource'] = mysqli_connect(
        $ASTRIA['databases'][$Database]['hostname'],
        $ASTRIA['databases'][$Database]['username'],
        $ASTRIA['databases'][$Database]['password'],
        $ASTRIA['databases'][$Database]['database']
        ) or die(mysql_error());
       break;
    default:
      die('Unsupported database type: "'.$ASTRIA['databases'][$Database]['type'].'" for database "'.$Database.'"');
    }
  }

}
