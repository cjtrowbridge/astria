<?php

Hook('Architect Tools 1','FeedSyncArchitectTools();');

function FeedSyncArchitectTools(){
  ?>
        <a href="/architect/feedsync" class="btn btn-outline-success"><i class="material-icons">&#xE0E5;</i> FeedSync</a>
  <?php
}


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


function FeedSyncDatabaseSetup(){
  $SQL="
    CREATE TABLE IF NOT EXISTS `Feed` (
      `FeedID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `FeedSourceID` int(11) NOT NULL,
      `FeedCategoryID` int(11) NOT NULL,
      `FeedParserID` int(11) DEFAULT NULL,
      `URL` varchar(255) NOT NULL,
      `FeedName` varchar(255) DEFAULT NULL,
      `FeedDescription` text,
      `FeedLogoURL` varchar(255) DEFAULT NULL,
      `MinimumInterval` int(11) NOT NULL DEFAULT '0',
      `TTL` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    
    CREATE TABLE IF NOT EXISTS `FeedFetch` (
      `FetchID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `FeedID` int(11) NOT NULL,
      `URL` varchar(255) NOT NULL,
      `Arguments` text NULL,
      `FetchTime` datetime NOT NULL,
      `Duration` decimal(10,4) NOT NULL,
      `Content` text,
      `ContentLength` int(11) NOT NULL,
      `Expires` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;
    
    CREATE TABLE IF NOT EXISTS `FeedCategory` (
      `FeedCategoryID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `Name` varchar(255) NOT NULL,
      `Description` text NOT NULL,
      `Path` varchar(255) NOT NULL,
      `ParentID` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
    
  ";
  global $ASTRIA;
  mysqli_multi_query($ASTRIA['databases']['astria']['resource'],$SQL);
}
