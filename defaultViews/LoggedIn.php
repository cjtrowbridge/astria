<?php

if(path(0)===false){
  Hook('User Is Logged In - Presentation','DefaultViewNoView();');
}

function defaultViewsHomepage(){
  Hook('Template Body','defaultViewsHomepageBodyCallback();');
  TemplateBootstrap4('Default Home Page');
}
function defaultViewsHomepageBodyCallback(){
  echo '<h1>Welcome To Glorious Astria.io</h1>';
  
}
