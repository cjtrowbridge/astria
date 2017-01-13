<?php 

global $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE;
$NUMBER_OF_QUERIES_RUN=0;
$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE=0;
$QUERIES_RUN='';

function Query(
	$SQL,
	$Database = 'astria core administrative database',
	$TTL = 60
){

	global $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN,$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE;
	
	$QUERIES_RUN.=$SQL."\n\n";
	
	//Check that database exists and is available, and connect to it.
	MakeSureDBConnected($Database);
	
	global $ASTRIA;
	switch($ASTRIA['databases'][$Database]['type']){
		case 'mysql':
			$sqlHash   = md5($SQL);
			$diskCache = readDiskCache($sqlHash,$TTL);
			if($diskCache==false){
				$result=mysqli_query($ASTRIA['databases'][$Database]['resource'], $SQL) or die(mysqli_error($ASTRIA['databases'][$Database]['resource']));
				if(is_bool($result)){
					return $result;
				}
				$Output=array();
				while($Row=mysqli_fetch_assoc($result)){
					$Output[]=$Row;
				}
				writeDiskCache($sqlHash,$Output);
				
				$NUMBER_OF_QUERIES_RUN+=1;
			}else{
				$Output = $diskCache;
				$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE+=1;
			}
			return $Output;
			//TODO if this is an insert or an update and there is a table with the same name followed by the table history suffix, run it on that table too with the returned primary key.
			break;
		default:
			die('Unsupported database type: "'.$ASTRIA['databases'][$Database]['type'].'"');
	}
	
}
