<?php

function Event($EventDescription){

  global $EVENTS, $ASTRIA;
  /*
    Call this function with a string EventDescription in order to allow callbacks to be hooked at this location in the script,
    as well as for verbose debugging and runtime analysis to take place.
  */
  
  /* EventDescription must be a string */
  if(is_string($EventDescription)){
    
    //BEGIN DEBUG SECTION
    
    global $DEBUG, $START_TIME;
    $temp_debug_output=array(
      'description'=> $EventDescription,
      'ram'=> (memory_get_usage()/1000000),
      'runtime'=>round(microtime(true)-$DEBUG[(count($DEBUG)-1)]['timestamp'],4),
      'timestamp'=> round(microtime(true)-$START_TIME,4)
    );
    $DEBUG[]=$temp_debug_output;
    
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
          
        }
      }
    }
    //END EVENT HANDLER SECTION
  }else{
    fail('Event Description Must Be A String;<br><pre>'.var_export($EventDescription,true).'</pre>');
  }
  
}
