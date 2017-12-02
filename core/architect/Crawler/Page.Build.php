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
  
  for($i = $Crawler['RangeMin']; $i < $Crawler['RangeMax']; $i+=$Crawler['RangeIncrement']){
    echo $Crawler['Protocol'].'://'.$Crawler['Domain'].'/'.$Crawler['Path'].'?'.$Crawler['QueryVariable1'].'='.$Query1Value.'&'.$Crawler['QueryVariable2'].'='.$Query2Value.'&'.$Crawler['RangeVariable'].'='.$i.'<br>';
  }
  
  exit;
}
