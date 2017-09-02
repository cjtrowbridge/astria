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
      $Feeds = Query('SELECT * FROM `Feed` LEFT JOIN FeedCategory ON FeedCategory.FeedCategoryID = Feed.FeedCategoryID ORDER BY Name DESC');
      $LastCategory = '';
      foreach($Feeds as $Feed){
        if(!($Feed['Name'] == $LastCategory)){
          if(!($LastCategory=='')){
            ?>
      </ul>
    </li>
            <?php
          }
          $LastCategory = $Feed['Name'];
          ?>
    <li><h2><?php echo $Feed['Name']; ?></h2>
      <ul>
          <?php
        }
    ?>
        <li><?php echo $Feed['URL']; ?></li>
    <?php } ?>
      </ul>
    </li>
  </ul>
  <?php
}
