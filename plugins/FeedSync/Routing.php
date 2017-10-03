<?php

Hook('Hourly Cron','FeedSyncFetchServiceCron();');

function FeedSyncFetchServiceCron(){
  
  //This might take a while, and thats fine.
  set_time_limit(0);
  //TODO logging for cron runtimes
  
  //Call each service in the appropriate order
  include_once('FeedSyncFetch.php');
  FeedSyncFetchService();
  Event('FeedSync Fetch Service Done');
  
}
