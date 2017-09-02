<?php

function FeedSyncHUD(){
  TemplateBootstrap4('FeedSyncUI','FeedSyncUIBodyCallback();');
}

function FeedSyncUIBodyCallback(){
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
