<?php

Hook('Hourly Cron','FeedSyncFetchServiceCron();');
function FeedSyncFetchServiceCron(){
  
  //This might take a while, and thats fine.
  set_time_limit(0);
  //TODO logging for cron runtimes
  
  //Include the files
  include('Fetch.php');
  
  //Call each service in the appropriate order
  echo '<p>FeedSyncFetchService...</p>';
  FeedSyncFetchService();
  
}
