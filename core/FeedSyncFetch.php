<?php

/*

  This is the fetching component of the FeedSync plugin for Astria v13.
  
  FeedSync enables the automatic fetching, parsing, and utilization of remote feeds. These can take the form of RSS,XML,JSON,etc.
  
  
  Fetch: At regular intervals, this extension will query its list of feeds and store the results in the database. 
  
  Parse: The parser service parses stored feed fetches into usable formats and stores them.
  
  Utilization: The utilization service executes code to utilize the data stored by the parse service.
  
*/

function FeedSyncFetchService(){
  
  //delete old data
  Query('DELETE FROM FeedFetch WHERE Expires < now()');
  
  //Get list of feeds
  //TODO make this work better with extremely large lists. It may need to batch the work automatically in order to work at enormous scale. This is not immediately necessary.
  
  $FeedSyncFetchService = microtime(true);
  $Feeds=Query("
    SELECT * FROM Feed
  ");
  foreach($Feeds as $Feed){
    $Next = $Feed['MinimumInterval']+strtotime($Feed['LastFetch']);
    if(time()>$Next){
      Query('UPDATE Feed SET LastFetch = NOW() WHERE FeedID = '.$Feed['FeedID']);
      FeedSyncFetch($Feed);
    }
  }
  
  global $FeedSyncFetchServiceDuration;
  $FeedSyncFetchServiceDuration = microtime(true) - $FeedSyncFetchService;
  
}

function FeedSyncFetch($Feed){
  global $ASTRIA;
  
  $Start    = microtime(true);
  $Content  = FetchURL($Feed['URL']);
  $End      = microtime(true);
  
  $Duration = $End - $Start;
  $URL      = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Feed['URL']);
  $Content  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Content);

  $Expires=date('Y-m-d H:i:s',(time()+$Feed['TTL']));
  
  Query("
    INSERT INTO `FeedFetch` (
      `FeedID`, `URL`, `Arguments`, `FetchTime`, `Duration`, `Content`, `ContentLength`, `Expires`
    ) VALUES (
      '".$Feed['FeedID']."', 
      '".$URL."', 
      NULL /* TODO: Arguments (This is complicated and not immediately necessary.) */, 
      NOW(), 
      '".$Duration."', 
      '".$Content."',
      '".strlen($Content)."',
      '".$Expires."'
    );
  ");
  
}
