<?php

global $EVENTS, $DEBUG;
$EVENTS=array();
if(!(is_dir('debug'))){
  mkdir('debug');
}

include_once('core/SHA256.php');

$DEBUG=array(
  'ThreadID' => sha256(uniqid(true)),
  0=>array(
    'description'=> 'Startup',
    'ram'=> (memory_get_usage()/1000000),
    'runtime'=>0,
    'timestamp'=> round(microtime(true),4)
  )
);

file_put_contents('debug/'.$DEBUG['ThreadID'].'.php','<?php '.PHP_EOL.'global $DEBUG_EXPORT;'.PHP_EOL.'if(!(isset($DEBUG_EXPORT))){$DEBUG_EXPORT=array();}'.PHP_EOL.PHP_EOL);

function Event($EventDescription){
  if(isset($_GET['verbose'])){
    echo $EventDescription."<br><br>\n\n";
  }

  global $EVENTS, $ASTRIA;
  /*
    Call this function with a string EventDescription in order to allow callbacks to be hooked at this location in the script,
    as well as for verbose debugging and runtime analysis to take place.
  */
  
  /* EventDescription must be a string */
  if(is_string($EventDescription)){
    
    //BEGIN DEBUG SECTION
    
    global $DEBUG, $START_TIME;
    if(isset($DEBUG[(count($DEBUG)-1)])){
      $Previous = $DEBUG[(count($DEBUG)-1)]['timestamp'];
    }else{
      $Previous=0;
    }
    $temp_debug_output=array(
      'description'=> $EventDescription,
      'ram'=> (memory_get_usage()/1000000),
      'runtime'=>round(microtime(true)-$Previous,4),
      'timestamp'=> round(microtime(true)-$START_TIME,4)
    );
    $DEBUG[]=$temp_debug_output;
    
    
    file_put_contents(
      'debug/'.$DEBUG['ThreadID'].'.php',
      '$DEBUG_EXPORT[] = '.var_export($temp_debug_output,true).PHP_EOL, 
      FILE_APPEND | LOCK_EX
    );
    
    
    if($ASTRIA['debugging']['verbose']){
      
      echo "\n<!-- Listing Hooks for Event: ".$EventDescription."\n\n";
      if(isset($EVENTS[$EventDescription])){
        var_dump($EVENTS[$EventDescription]);
        echo "\n";
      }else{
        echo "No Hooks\n";
      }
      pd($temp_debug_output);
      echo "\n-->\n\n";
      
      ob_flush();
      flush();
      
    }
    
    
    
    if($EventDescription=='end'){
      if($ASTRIA['debugging']['verbose']){
        DebugShowSummary();
      }
      $total_runtime=microtime()-$DEBUG[0]['time'];
      //TODO make this work with the new database functions
      //mysql_query("INSERT INTO request_time(`time`,`duration`,`memory`,`request`)VALUES(NOW( ),'".safe($total_runtime)."','".safe(memory_get_usage()/1000000)."','".$_SERVER['REQUEST_URI']."');");
    }
    
    //END DEBUG SECTION
    //BEGIN EVENT HANDLER SECTION
    
    if(isset($EVENTS[$EventDescription])){
      foreach($EVENTS[$EventDescription] as $Callback){
        /* Note that the callback is evaluated, and as such can be any php script. */
        try{
          
          eval($Callback);
          
        }catch(Exception $e){
          
          global $EventException;
          $EventException=$e;
          
          Event('Event Exception');
          if(true||isset($_GET['verbose'])){
            echo '<p><b>EVENT THREW EXCEPTION!</b></p>';
            pd($EventException);
          }
          
        }
      }
    }
    //END EVENT HANDLER SECTION
  }else{
    fail('Event Description Must Be A String;<br><pre>'.var_export($EventDescription,true).'</pre>');
  }
  
}


function Hook($EventDescription,$Callback,$Supremacy = false){
  global $EVENTS;
  /*
    Call this function with a string EventDescription and a Callback in order to hook that callback to the location of the 
    corresponding Event for that EventDescription.
    
    Supremacy removes any existing Hooks before adding this one. 
  */
  
  /* EventDescription must be a string */
  if(is_string($EventDescription)){
  
    /* Make sure this event descriptor exists within the global pegboard variable. */
    if(
      (!(isset($EVENTS[$EventDescription])))||
      $Supremacy
    ){
      $EVENTS[$EventDescription]=array();
    }
    
    /* Add the callback to the array for this descriptor */
    $EVENTS[$EventDescription][]=$Callback;
  }else{
    fail('<h1>Event Description Must Be A String;</h1><pre>'.var_export($EventDescription,true).'</pre>');
  }
  
}


function DebugShowSummary(){
  
  global $DEBUG;
  echo "<h3>Debug Summary:</h3>\n";
  $summary=array(
    array(
      'Total Runtime' => ($DEBUG[(count($DEBUG)-1)]['timestamp']-$DEBUG[0]['timestamp']).'  seconds',
      'Total RAM' => $DEBUG[(count($DEBUG)-1)]['ram'].' megabytes'
    )
  );
  echo ArrTabler($summary);
  echo "<h3>Debug Details:</h3>\n";
  echo ArrTabler($DEBUG);
  ?>
  <script>$('.tablesorter').tablesorter({widgets: ["zebra", "filter"]});</script>
  <?php 
  
}



Hook('Hourly Webhook', 'DebugServiceDumpToDatabase();' );

function DebugServiceDumpToDatabase(){
  if($handle = opendir('debug')){
    
    $SQL = "
      INSERT INTO Debug(ThreadID,Description, RAM, Runtime, Timestamp) VALUES
    ";
    
    while (false !== ($Identifier = readdir($handle))){
      $include_path='debug/'.$Identifier;
      if((!(strpos($Identifier,'.php')===false)) && $Identifier != "." && $Identifier != ".." && file_exists($include_path)){
        
        global $DEBUG_EXPORT;
        $DEBUG_EXPORT=array();
        Event('Debug Service: Before Dumping To Database: '.$include_path);
        include_once($include_path);
        //rm($include_path);
        Event('Debug Service: After Dumping To Database: '.$include_path);
        $SQL .= "
          ('".Sanitize($Identifier)."','".Sanitize($DEBUG_EXPORT[0]['description'])."','".Sanitize($DEBUG_EXPORT[0]['ram'])."','".Sanitize($DEBUG_EXPORT[0]['runtime'])."','".date('Y-m-d H:i:s',strtotime($DEBUG_EXPORT[0]['timestamp']))."'),";
        
      }
    }
    closedir($handle);
    
    pd($SQL);
    
  }
}

function DebugServiceDumpToDatabasepd(){
  echo '<pre>';
  DebugServiceDumpToDatabase();
  echo '</pre>';
  
}

Hook('Architect Homepage','DebugServiceDumpToDatabasepd();')
