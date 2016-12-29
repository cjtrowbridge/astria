<?php 

global $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN;
$NUMBER_OF_QUERIES_RUN=0;
$QUERIES_RUN='';

function Query(
	$SQL,
	$Database = 'astria core administrative database',
	$ForceFresh = false
){

	global $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN;
	$NUMBER_OF_QUERIES_RUN+=1;
	$QUERIES_RUN.=$SQL."\n\n";
	
	//Check that database exists and is available, and connect to it.
	MakeSureDBConnected($Database);
	
	global $ASTRIA;
	switch($ASTRIA['databases'][$Database]['type']){
		case 'mysql':
			$result=mysqli_query($ASTRIA['databases'][$Database]['resource'], $SQL) or die(mysqli_error());
			if(!(is_bool($result))){
				$Output=array();
				while($Row=mysqli_fetch_assoc($result)){
					$Output[]=$Row;
				}
				return $Output;
			}
			break;
		default:
			die('Unsupported database type: "'.$ASTRIA['databases'][$Database]['type'].'"');
	}
	
}
