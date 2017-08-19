<?php

//This should always run regardless of the state or route. It will only do anything if appropriate and it never outputs anything.
ExternalAnalytics();

function ExternalAnalytics(){
  global $ASTRIA;
  if(isset($ASTRIA['analytics'])){
  
    if(isset($ASTRIA['analytics']['Google'])){
      Hook('Template Head','GoogleAnalyticsSnippet();');
    }
    
    
  
  }
}

function GoogleAnalyticsSnippet(){
  global $ASTRIA;
  echo PHP_EOL.$ASTRIA['analytics']['Google'].PHP_EOL;
}
