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
      $Feeds = Query('SELECT * FROM `Feed` LEFT JOIN FeedCategory ON FeedCategory.FeedCategoryID = Feed.FeedCategoryID ORDER BY Name ASC');
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
      <li><h2>Category: <a href="/architect/feedsync/category/<?php if($Feed['Path']==''){echo $Feed['FeedCategroryID'];}else{echo $Feed['Path'];} ?>"><?php echo $Feed['Name']; ?></a></h2>
      <ul>
          <?php
        }
    ?>
        <li><a href="/architect/feedsync/feed/<?php echo $Feed['FeedID']; ?>"><?php echo $Feed['URL']; ?></a></li>
    <?php } ?>
      </ul>
    </li>
  </ul>
  <?php
}
