<?php 

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
