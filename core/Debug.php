<?php

function DebugShowSummary(){
  
  global $DEBUG, $EVENTS;
  echo "<h3>Debug Summary:</h3>\n";
  $summary=array(
    array(
      'Total Runtime' => ($DEBUG[(count($DEBUG)-1)]['timestamp']-$DEBUG[0]['timestamp']).'  seconds',
      'Total RAM' => $DEBUG[(count($DEBUG)-1)]['ram'].' megabytes'
    )
  );
  echo ArrTabler($summary);
  
  echo '<h3><a href="javascript:void(0);" onclick="$(\'#debugSummaryDetails\').slideToggle();">Details:</a></h3>'.PHP_EOL;
  echo '<div id="debugSummaryDetails" style="display: none;">'.PHP_EOL;
  rsort($DEBUG);
  echo ArrTabler($DEBUG);
  echo '</div>';
  
  echo '<h3><a href="javascript:void(0);" onclick="$(\'#debugSummaryEvents\').slideToggle();">Events:</a></h3>'.PHP_EOL;
  echo '<div id="debugSummaryEvents" style="display: none;">'.PHP_EOL;
  pd($EVENTS);
  echo '</div>';
  
  echo '<h3><a href="javascript:void(0);" onclick="$(\'#debugSummaryPermissions\').slideToggle();">Permissions:</a></h3>'.PHP_EOL;
  echo '<div id="debugSummaryPermissions" style="display: none;">'.PHP_EOL;
  global $ASTRIA;
  $Permission = $ASTRIA['Session']['User']['Permission'];
  rsort($Permission);
  pd($Permission);
  unset($Permission);
  echo '</div>';
  
  ?>
  <script>$('.tablesorter').tablesorter({widgets: ["zebra", "filter"]});</script>
  <?php 
  
}


Hook('Hourly Webhook', 'DebugServiceDumpToDatabase();' );
Hook('User Is Logged In', 'DebugServiceDumpToDatabaseOverride();' );
//Hook('Architect Homepage', 'DebugServiceDumpToDatabase();' );

function DebugServiceDumpToDatabaseOverride(){
  if(isset($_GET['DebugServiceDumpToDatabaseOverride'])){
    if(
      IsAstriaAdmin()
    ){
      DebugServiceDumpToDatabase();
      exit;
    }else{
      die('You are not an admin');
    }
  }
}

function DebugServiceDumpToDatabase(){
  
  if(!(is_dir('debug'))){
    Event('No debug dir. Cancelling debug dump service.');
    return;
  }
  
  //check if there is a debug table
  global $ASTRIA;
  $DBName = $ASTRIA['databases']['astria']['database'];
  $Check = Query("SELECT COUNT(*) as 'Count' FROM information_schema.tables WHERE table_schema = '".$DBName."' AND table_name = 'Debug';");
  if($Check[0]['Count']==0){
    Query("
      CREATE TABLE `Debug` (
        `ThreadID` varchar(255) NOT NULL,
        `Description` varchar(255) NOT NULL,
        `RAM` float(20,10) NOT NULL,
        `Runtime` float(20,10) NOT NULL,
        `Timestamp` float(20,10) NOT NULL,
        `DateTime` datetime NOT NULL
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
  }
  
  
  //Delete everything but the top 50,000 rows. This equates to about one-hundred requests
  Query("
    DELETE FROM Debug 
    WHERE ThreadID 
    NOT IN (
        SELECT * FROM (
            SELECT ThreadID 
            FROM Debug
            ORDER BY DateTime DESC
            LIMIT 50000) r
    )
  ");
  
  
  if($handle = opendir('debug')){
    
    $SQL = "
      INSERT INTO Debug(ThreadID,Description, RAM, Runtime, Timestamp, DateTime) VALUES
    ";
    
    while (false !== ($Identifier = readdir($handle))){
      $include_path='debug/'.$Identifier;
      if((!(strpos($Identifier,'.php')===false)) && $Identifier != "." && $Identifier != "index.php" && $Identifier != ".." && file_exists($include_path)){
        
        global $DEBUG_EXPORT;
        $DEBUG_EXPORT=array();
        include_once($include_path);
        unlink($include_path);
        foreach($DEBUG_EXPORT as $Entry){
          $SQL .= "
            ('".str_replace('.php','',Sanitize($Identifier))."','".Sanitize($Entry['description'])."','".Sanitize($Entry['ram'])."','".Sanitize($Entry['runtime'])."','".Sanitize($Entry['timestamp'])."','".date('Y-m-d H:i:s',intval(round($Entry['timestamp'])))."'),";
        }
        Event('DebugServiceDumpToDatabase: Completed One.');
        
      }
    }
    closedir($handle);
    
    $SQL=rtrim($SQL,',').';';
    Query($SQL);
    
  }
}
