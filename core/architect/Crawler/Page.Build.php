<?php

function Architect_Crawler_Build(){
  $CrawlerID = intval(path(3));
  if($CrawlerID == false){
    die('Invalid Crawler ID');
  }
  
  $Crawler = Query('SELECT * FROM Crawler WHERE CrawlerID = '.$CrawlerID);
  if(!(isset($Crawler[0]))){
    die('Crawler Not Found');
  }
  $Crawler=$Crawler[0];
  
  pd($Crawler);
  
  $Query1Value = 'plumbing';
  $Query2Value = '95603';
  
  $Actions = array();
  
  for($i = $Crawler['RangeMin']; $i < $Crawler['RangeMax']; $i+=$Crawler['RangeIncrement']){
    $URL = $Crawler['Protocol'].'://'.$Crawler['Domain'].'/'.$Crawler['Path'].'?'.$Crawler['QueryVariable1'].'='.$Query1Value.'&'.$Crawler['QueryVariable2'].'='.$Query2Value.'&'.$Crawler['RangeVariable'].'='.$i
    $Actions[$URL] = $URL;
  }
  
  //Find any of these whcih are already inserted while not yet done.
  $SQL = "SELECT URL FROM CrawlerTask WHERE Data IS NULL AND (".PHP_EOL;
  foreach($Actions as $Action){
    $SQL.="URL LIKE '".Sanitize($Action)."' OR".PHP_EOL;
  }
  $SQL.="1=2 )";
  $Alreadys = Query($SQL);
    
  //Remove any actions which are already queued
  foreach($Alreadys as $Already){
    unset($Action[$Already]);
  }
  
  pd($Actions);
  
  exit;
}
