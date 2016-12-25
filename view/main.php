<?php

include('loadViews.php');

Hook('User Is Logged In - No Presentation','noView();');

function noView(){
  Hook('Template Body','noViewBodyCallback();');
  TemplateBootstrap2('404');
}
function noViewBodyCallback(){
  global $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $DEBUG;
  //echo '<h1>404: Page not found.</h1> User '.$_SESSION['User']['Email'].' is logged in, but nothing happened at this url. Runtime '.round(microtime(true)-STARTTIME,4)." seconds. \n\n\n\n<!-- QUERIES RUN \n".addslashes($QUERIES_RUN)."-->\n\n\n\n".$NUMBER_OF_QUERIES_RUN.' Queries Run.</span> Session Expires '.date('r',$_SESSION['Auth']['Expires']).'. <a href="./?logout">Log Out</a>.';
  echo '<h1>404: Page not found.</h1>';
  echo 'User '.$_SESSION['User']['Email'].' is logged in, but nothing happened at this url.<br>';
  echo 'Runtime '.round(microtime(true)-$DEBUG[0]['time'],4)." seconds.<br>";
  echo 'Ran '.$NUMBER_OF_QUERIES_RUN.' Queries.<br>';
  echo 'Session Expires '.date('r',$_SESSION['Auth']['Expires']).'.<br>';
  echo '<a href="/?logout">Log Out</a>.';
  //pd($_SESSION); 
}
