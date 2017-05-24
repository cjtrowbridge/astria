<?php

Hook('Hourly Cron','FeedSyncFetchServiceCron();');
function FeedSyncFetchServiceCron(){
  
  //Include the files
  include('Fetch.php');
  
  //Call each service in the appropriate order
  FeedSyncFetchService();
  
}
