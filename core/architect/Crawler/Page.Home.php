<?php

function Architect_Crawler_Homepage(){
  
  
  TemplateBootstrap4('New - Crawler - Architect','Architect_Crawler_Homepage_BodyCallback();');
}

function Architect_Crawler_Homepage_BodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/crawler">Crawler</a></h1>
  <p>This should be a status page of all the details about the crawls we are doing.</p>
  <?php
}
