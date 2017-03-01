<?php


Hook('User Is Logged In - Presentation','DefaultViewNoView();');

function defaultViewsHomepage(){
  if(path(0)===false){
    Hook('Template Body','defaultViewsHomepageBodyCallback();');
    TemplateBootstrap4('Default Home Page');
  }
}
function defaultViewsHomepageBodyCallback(){
  global $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $DEBUG, $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE,$ASTRIA;
  echo '<h1>Welcome To Glorious Astria.io</h1>';
  
}
