<?php

Hook('Hourly Cron','FeedSyncFetchServiceCron();');
function FeedSyncFetchServiceCron(){
  include('Fetch.php');
  FeedSyncFetchService();
}
