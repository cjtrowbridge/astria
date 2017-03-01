<?php

Hook('User Is Logged In - No Presentation','DefaultViewNoView();');

function DefaultViewNoView(){
  Hook('Template Body','DefaultViewNoViewBodyCallback();');
  TemplateBootstrap4('404');
}
function DefaultViewNoViewBodyCallback(){
  global $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $DEBUG, $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE,$ASTRIA;
  echo '<h1>404: Page not found.</h1>';
  echo 'User '.$ASTRIA['Session']['User']['Email'].' is logged in, but nothing happened at this url.<br>';
  echo 'Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4)." seconds.<br>";
  echo 'Ran '.$NUMBER_OF_QUERIES_RUN.' Database Queries.<br>';
  echo 'Ran '.$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE.' Queries From Disk Cache.<br>';
  echo 'Session Expires '.date('r',$ASTRIA['Session']['Auth']['Expires']).'.<br>';
  echo '<a href="/?logout">Log Out</a>.';
}
