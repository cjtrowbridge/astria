<?php

function Architect_Crawler_Homepage(){
  
  
  TemplateBootstrap4('New - Crawler - Architect','Architect_Crawler_Homepage_BodyCallback();');
}

function Architect_Crawler_Homepage_BodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/crawler">Crawler</a></h1>
  
  <?php 
    $Crawlers = Query('SELECT * FROM Crawlers');
    foreach($Crawlers as $Crawler){
      pd($Crawler);
    }
  
}
