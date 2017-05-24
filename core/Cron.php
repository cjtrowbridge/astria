<?php

Hook('Before Login','Cron();');

function Cron(){

  if(!(
    isset($_GET['cron'])||
    path(0)=='cron'
  )){
    return;
  }
 
  $CronStart = microtime(true);
  
  $LastHourlyCron = intval(CacheDatabaseRead(md5('Last Hourly Cron')));
  if($LastHourlyCron < (time()-60*60)){
    CacheDatabaseWrite(md5('Last Hourly Cron'),time());
    echo '<p>Hourly Cron Last Ran '.ago($LastHourlyCron).'. Running Now...</p>';
    Event('Hourly Cron');
  }else{
    echo '<p>Skipping Hourly Cron Because It Last Ran '.ago($LastHourlyCron).'.</p>';
  }
  
  $LastDailyCron = intval(CacheDatabaseRead(md5('Last Daily Cron')));
  if($LastDailyCron < (time()-60*60*24)){
    CacheDatabaseWrite(md5('Last Daily Cron'),time());
    echo '<p>Daily Cron Last Ran '.ago($LastDailyCron).'. Running Now...</p>';
    Event('Daily Cron');
  }else{
    echo '<p>Skipping Daily Cron Because It Last Ran '.ago($LastDailyCron).'.</p>';
  }
  
  $LastWeeklyCron = intval(CacheDatabaseRead(md5('Last Weekly Cron')));
  if($LastWeeklyCron < (time()-60*60*24*7)){
    CacheDatabaseWrite(md5('Last Weekly Cron'),time());
    echo '<p>Weekly Cron Last Ran '.ago($LastWeeklyCron).'. Running Now...</p>';
    Event('Weekly Cron');
  }else{
    echo '<p>Skipping Weekly Cron Because It Last Ran '.ago($LastWeeklyCron).'.</p>';
  }
  
  $CronEnd  = microtime(true);
  $Duration = $CronEnd-$CronStart;
  $Duration = round($Duration,4);
  
  die('<p>Cron Finished In '.$Duration.' Seconds.</p>');
}
