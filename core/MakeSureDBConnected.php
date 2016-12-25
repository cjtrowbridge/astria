<?php

function MakeSureDBConnected($Database='astria core administrative database'){

global $ASTRIA;

if(!(isset($DATABASES[$Database]))){die("Database configuration not found for '".$Database."'. Please add to config.php.");}

if($DATABASES[$Database]['resource']==false){
switch($DATABASES[$Database]['type']){
case 'mysql':
$DATABASES[$Database]['resource'] = mysqli_connect(
$DATABASES[$Database]['hostname'],
$DATABASES[$Database]['username'],
$DATABASES[$Database]['password'],
$DATABASES[$Database]['database']
) or die(mysql_error());
break;
default:
die('Unsupported database type: "'.$DATABASES[$Database]['type'].'" for database "'.$Database.'"');
}
}

}
