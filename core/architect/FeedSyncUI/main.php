<?php

function FeedSyncUI(){
  switch(path(2)){
    
    
    case 'setup':
      SetupFeedSync();
      break;
    case false:
      include('FeedSyncHUD.php');
      FeedSyncHUD();
      break;
  }
}

function SetupFeedSync(){
  
  //Make sure this has not already been done...
  $Check = Query("SHOW TABLES LIKE 'Feed';");
  if(count($Check) > 0){
    return;
  }
  
  Query("
    CREATE TABLE `Feed` (
      `FeedID` int(11) NOT NULL,
      `FeedSourceID` int(11) NOT NULL,
      `FeedCategoryID` int(11) NOT NULL,
      `FeedParserID` int(11) DEFAULT NULL,
      `URL` varchar(255) NOT NULL,
      `FeedName` varchar(255) DEFAULT NULL,
      `FeedDescription` text,
      `FeedLogoURL` varchar(255) DEFAULT NULL,
      `MinimumInterval` int(11) NOT NULL DEFAULT '0',
      `LastFetch` datetime DEFAULT NULL,
      `TTL` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");
  Query("
    CREATE TABLE `FeedCategory` (
      `FeedCategoryID` int(11) NOT NULL,
      `Name` varchar(255) NOT NULL,
      `Description` text NOT NULL,
      `Path` varchar(255) NOT NULL,
      `ParentID` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
  ");
  Query("
    CREATE TABLE `FeedFetch` (
      `FetchID` int(11) NOT NULL,
      `FeedID` int(11) NOT NULL,
      `URL` varchar(255) NOT NULL,
      `Arguments` text,
      `FetchTime` datetime NOT NULL,
      `Duration` decimal(10,4) NOT NULL,
      `Content` text,
      `ContentLength` int(11) NOT NULL,
      `Expires` datetime DEFAULT NULL,
      `ItemCount` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;
  ");
  Query("
    CREATE TABLE `FeedSource` (
      `FeedSourceID` int(11) NOT NULL,
      `Name` varchar(255) NOT NULL,
      `Description` text NOT NULL,
      `LogoURL` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
  ");
  Query("
    ALTER TABLE `Feed` ADD PRIMARY KEY (`FeedID`), ADD KEY `SourceID` (`FeedSourceID`);
  ");
  Query("
    ALTER TABLE `FeedCategory` ADD PRIMARY KEY (`FeedCategoryID`);
  ");
  Query("
    ALTER TABLE `FeedFetch` ADD PRIMARY KEY (`FetchID`);
  ");
  Query("
    ALTER TABLE `FeedSource` ADD PRIMARY KEY (`FeedSourceID`);
  ");
  Query("
    ALTER TABLE `Feed` MODIFY `FeedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;
  ");
  Query("
    ALTER TABLE `FeedCategory` MODIFY `FeedCategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
  ");
  Query("
    ALTER TABLE `FeedFetch` MODIFY `FetchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242995;
  ");
  Query("
    ALTER TABLE `FeedSource` MODIFY `FeedSourceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
  ");
  
  header('Location: /architect/feedsync');
  exit;
}
