<?php

define('CRONTIMESTAMPMARGIN',60); //This is to allow for the time it takes to call the cron job, otherwise it would always jump ahead by one hour.

Hook('Before Login','Cron();');

function Cron(){

  if(!(
    isset($_GET['cron'])||
    path(0)=='cron'
  )){
    return;
  }
 
  $CronStart     = microtime(true);
  $CronTimestamp = time();
  
  $LastHourlyCron = intval(CacheDatabaseRead(md5('Last Hourly Cron')));
  if($LastHourlyCron < ($CronTimestamp-60*60-CRONTIMESTAMPMARGIN)){
    CacheDatabaseWrite(md5('Last Hourly Cron'),time());
    echo '<p>Hourly cron last ran '.ago($LastHourlyCron).'. Running now...</p>';
    Event('Hourly Cron');
  }else{
    echo '<p>Skipping hourly cron because it last ran <span title="'.$LastHourlyCron.'">'.ago($LastHourlyCron).'</span>.</p>';
  }
  
  $LastDailyCron = intval(CacheDatabaseRead(md5('Last Daily Cron')));
  if($LastDailyCron < ($CronTimestamp-60*60*24-CRONTIMESTAMPMARGIN)){
    CacheDatabaseWrite(md5('Last Daily Cron'),time());
    echo '<p>Daily cron last ran '.ago($LastDailyCron).'. Running now...</p>';
    Event('Daily Cron');
  }else{
    echo '<p>Skipping daily cron because it last ran '.ago($LastDailyCron).'.</p>';
  }
  
  $LastWeeklyCron = intval(CacheDatabaseRead(md5('Last Weekly Cron')));
  if($LastWeeklyCron < ($CronTimestamp-60*60*24*7-CRONTIMESTAMPMARGIN)){
    CacheDatabaseWrite(md5('Last Weekly Cron'),time());
    echo '<p>Weekly cron last ran '.ago($LastWeeklyCron).'. Running now...</p>';
    Event('Weekly Cron');
  }else{
    echo '<p>Skipping weekly cron because it last ran '.ago($LastWeeklyCron).'.</p>';
  }
  
  $CronEnd  = microtime(true);
  $Duration = $CronEnd-$CronStart;
  $Duration = round($Duration,4);
  
  die('<p>Cron finished in '.$Duration.' seconds.</p>');
}
