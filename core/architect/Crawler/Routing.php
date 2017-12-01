<?php

//this is a web crawler which can create schema and fill it with data based on crawls

Hook('User Is Logged In','CrawlerLoad();');
function CrawlerLoad(){
  if(HasPermission('Architect_Crawler')){
    //this happens already in the main architect router
    //Hook('User Is Logged In - Presentation','Architect_Crawler_Routing();');
    Hook('Architect Tools 1','Crawler_ArchitectButton();');
  }
}

function Crawler_ArchitectButton(){
  ?>
  <a class="btn btn-outline-success" href="/architect/crawler/"><i class="material-icons">cloud_download</i> Crawler</a>
  <?php
}
function Architect_Crawler_Routing(){
  if(
    path(0)=='architect' &&
    path(1)=='crawler' &&
    HasPermission('Architect_Crawler')
  ){
    
    switch(path(1)){
      case 'new':
        include_once('Page.New.php');
        Architect_Crawler_New();
        break;
      case false:
        include_once('Page.Home.php');
        Architect_Crawler_Homepage();
        break;
    }
  }
}
