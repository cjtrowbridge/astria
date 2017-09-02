<?php

function FeedSyncHUD(){
  TemplateBootstrap4('FeedSyncUI','FeedSyncUIBodyCallback();');
}

function FeedSyncUIBodyCallback(){
  
  //This is intended to catch an error if it is run before setup has completed so we need to turn off error reporting, but then set it back to whatever it was before.
  $OldErrorReportingLevel = error_reporting();
  error_reporting(0);
  $Check = Query('SELECT 1 FROM `Feed` LIMIT 1');
  error_reporting($OldErrorReportingLevel);
  
  if($Check == FALSE){
    ?><h1>FeedSync Setup</h1>
    <p>To add the required tables to use FeedSync, <a href="/architect/feedsync/setup">click here</a>.</p>
    <?php
    return;
  }
  
  ?><h1>Your Feeds</h1>
  <ul>
    <?php
      $Feeds = Query('SELECT * FROM Feed');
      foreach($Feeds as $Feed){
        pd($Feed);
    ?>
    <li></li>
    <?php } ?>
  </ul>
  <?php
}
