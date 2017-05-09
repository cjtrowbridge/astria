<?php

Hook('User Is Logged In - Before Presentation','MaybeDefaultHomepage();');

function MaybeDefaultHomepage(){
  if(path(0)===false){
    Hook('Template Body','defaultViewsHomepageBodyCallback();');
    TemplateBootstrap4('Default Home Page');
  }
}
function defaultViewsHomepageBodyCallback(){
  echo '<h1>Welcome To Glorious Astria.io</h1>';
  
}
