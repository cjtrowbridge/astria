<?php

/*

  Astria Github Attribution
  
  This adds a link to the Astria Github to the navbar at the top of the page. Feel free to comment or remove this, or to leave it in!
  
*/
Hook('User Is Logged In - Before Presentation','AstriaGithubAttribution();');

function AstriaGithubAttribution(){
  global $ASTRIA;
  $ASTRIA['nav']['main']['Github']='https://github.com/cjtrowbridge/astria';
}
