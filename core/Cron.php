<?php

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
  if(!(date("Y-m-d H",$LastHourlyCron) == date('Y-m-d H',$CronTimestamp))){
    CacheDatabaseWrite(md5('Last Hourly Cron'),$CronTimestamp);
    echo '<p>Hourly cron last ran '.ago($LastHourlyCron).'. Running now...</p>';
    Event('Hourly Cron');
  }else{
    echo '<p>Skipping hourly cron because it last ran <span title="'.$LastHourlyCron.'">'.ago($LastHourlyCron).'</span>.</p>';
  }
  
  $LastDailyCron = intval(CacheDatabaseRead(md5('Last Daily Cron')));
  if(!(date('Y-m-d',$LastDailyCron) == date('Y-m-d',$CronTimestamp))){
    CacheDatabaseWrite(md5('Last Daily Cron'),$CronTimestamp);
    echo '<p>Daily cron last ran '.ago($LastDailyCron).'. Running now...</p>';
    Event('Daily Cron');
  }else{
    echo '<p>Skipping daily cron because it last ran '.ago($LastDailyCron).'.</p>';
  }
  
  $LastWeeklyCron = intval(CacheDatabaseRead(md5('Last Weekly Cron')));
  if(!(date('Y W',$LastWeeklyCron) == date('Y W',$CronTimestamp))){
    CacheDatabaseWrite(md5('Last Weekly Cron'),$CronTimestamp);
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
