<?php

/*

  This is the fetching component of the FeedSync plugin for Astria v13.
  
  FeedSync enables the automatic fetching, parsing, and utilization of remote feeds. These can take the form of RSS,XML,JSON,etc.
  
  
  Fetch: At regular intervals, this extension will query its list of feeds and store the results in the database. 
  
  Parse: The parser service parses stored feed fetches into usable formats and stores them.
  
  Utilization: The utilization service executes code to utilize the data stored by the parse service.
  
*/

function FeedSyncFetchService(){
  
  /*
    CREATE TABLE IF NOT EXISTS `FeedSyncFeed` (
      `FeedID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `URL` varchar(255) NOT NULL,
      `MinimumInterval` int(11) NOT NULL DEFAULT '0',
      `LastFetch` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;
    
    CREATE TABLE IF NOT EXISTS `FeedSyncFetch` (
      `FetchID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `FeedID` int(11) NOT NULL,
      `URL` varchar(255) NOT NULL,
      `Arguments` text NULL,
      `FetchTime` datetime NOT NULL,
      `Duration` decimal(10,4) NOT NULL,
      `Content` text,
      `ContentLength` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;
  */
  
  //Get list of feeds
  //TODO make this work better with extremely large lists. It may need to batch the work automatically in order to work at enormous scale. This is not immediately necessary.
  $Feeds=Query("
    SELECT * FROM FeedSyncFeed
  ");
  foreach($Feeds as $Feed){
    $Next = $Feed['MinimumInterval']+strtotime($Feed['LastFetched']);
    if(time()>$Next){
      Query('UPDATE FeedSyncFeed SET LastFetch = NOW() WHERE FeedID = '.$Feed['FeedID']);
      FeedSyncFetch($Feed);
    }
  }
  
}

function FeedSyncFetch($Feed){
  global $ASTRIA;
  
  $Start    = microtime(true);
  $Content  = FetchURL($Feed['URL']);
  $End      = microtime(true);
  
  $Duration = $End - $Start;
  $URL      = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Feed['URL']);
  $Content  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Content);

  Query("
    INSERT INTO `FeedSyncFetch` (
      `FeedID`, `URL`, `Arguments`, `FetchTime`, `Duration`, `Content`, `ContentLength`
    ) VALUES (
      '".$Feed['FeedID']."', 
      '".$URL."', 
      NULL /* TODO: Arguments (This is complicated and not immediately necessary.) */, 
      NOW(), 
      '".$Duration."', 
      '".$Content."',
      '".strlen($Content)."'
    );
  ");
  
}
