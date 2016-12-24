<?php

function Event($EventDescription){

  global $EVENTS;
  /*
    Call this function with a string EventDescription in order to allow callbacks to be hooked at this location in the script,
    as well as for verbose debugging and runtime analysis to take place.
  */
  
  /* EventDescription must be a string */
  if(is_string($EventDescription)){
    
    //BEGIN DEBUG SECTION
    
    if(isset($_GET['debug'])&&DEBUG_ENABLED){
      echo '<div><p>'.$EventDescription.'</p></div>';
      ob_flush();
      flush();
    }
    global $DEBUG, $START_TIME;
    $temp_debug_output=array(
      'debug point'=> $EventDescription,
      'memory usage'=> (memory_get_usage()/1000000),
      'runtime'=>round(microtime(true)-$DEBUG[(count($DEBUG)-1)]['time'],4),
      'time'=> round(microtime(true)-$START_TIME,4)
    );
    $DEBUG[]=$temp_debug_output;
    if(isset($_GET['debug'])&&DEBUG_ENABLED){
      pd($temp_debug_output);
      ob_flush();
      flush();
    }
    if($EventDescription=='end'){
      if(isset($_GET['debug'])&&DEBUG_ENABLED){
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
          
        }
      }
    }
    //END EVENT HANDLER SECTION
  }else{
    fail('<h1>Event Description Must Be A String;</h1><pre>'.var_export($EventDescription,true).'</pre>');
  }
  
}
