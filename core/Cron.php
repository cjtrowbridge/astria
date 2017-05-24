<?php

Hook('Before Login','Cron();');

function Cron(){

  if(!(
    isset($_GET['cron'])||
    path(0)=='cron'
  )){
    return;
  }
 
  $LastHourlyCron = intval(ReadCache(md5('Last Hourly Cron')));
  if($LastHourlyCron < (time()-60*60)){
    WriteCache(md5('Last Hourly Cron'),time());
    Event('Hourly Cron');
  }
  
  $LastDailyCron = intval(ReadCache(md5('Last Daily Cron')));
  if($LastDailyCron < (time()-60*60*24)){
    WriteCache(md5('Last Daily Cron'),time());
    Event('Daily Cron');
  }
  
  $LastWeeklyCron = intval(ReadCache(md5('Last Weekly Cron')));
  if($LastWeeklyCron < (time()-60*60*24*7)){
    WriteCache(md5('Last Weekly Cron'),time());
    Event('Weekly Cron');
  }
  
}
