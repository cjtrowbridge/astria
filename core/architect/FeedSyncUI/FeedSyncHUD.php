<?php

function FeedSyncHUD(){
  TemplateBootstrap4('FeedSyncUI','FeedSyncUIBodyCallback();');
}

function FeedSyncUIBodyCallback(){
  
  $Check = Query("SHOW TABLES LIKE 'Feed';");
  
  if(count($Check) == 0){
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
    ?>
    <li><?php echo $Feed['FeedURL']; ?></li>
    <?php } ?>
  </ul>
  <?php
}
