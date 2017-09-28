<?php

function FeedSyncFeedPage(){
  if(
    isset($_POST['URL'])
  ){
      if($_POST['FeedSourceID']==''){
        $mFeedSourceID = "NULL";
      }else{
        $mFeedSourceID = "'".intval($_POST['FeedSourceID'])."'";
      }
      
      if($_POST['FeedCategoryID']==''){
        $mFeedCategoryID = "NULL";
      }else{
        $mFeedCategoryID = "'".intval($_POST['FeedCategoryID'])."'";
      }
      
      if($_POST['FeedParserID']==''){
        $mFeedParserID = "NULL";
      }else{
        $mFeedParserID = "'".intval($_POST['FeedParserID'])."'";
      }
      
    //Something being submitted
    //But is it a new or an update?
    
    if(isset($_POST['FeedCategoryID'])){
      
      //Update
      Query("
        UPDATE `Feed` SET 
        
          `FeedSourceID`    = ".$mFeedSourceID.", 
          `FeedCategoryID`  = ".$mFeedCategoryID.",
          `FeedParserID`    = ".$mFeedParserID.",
          `URL`             = '".Sanitize($_POST['URL'])."',
          `FeedName`        = '".Sanitize($_POST['FeedName'])."', 
          `FeedDescription` = '".Sanitize($_POST['FeedDescription'])."', 
          `FeedLogoURL`     = '".Sanitize($_POST['FeedLogoURL'])."', 
          `MinimumInterval` = '".Sanitize($_POST['MinimumInterval'])."', 
          `LastFetch`       = '".Sanitize($_POST['LastFetch'])."', 
          `TTL`             = '".Sanitize($_POST['TTL'])."'
          
        WHERE `Feed`.`FeedID` = ".intval(Sanitize($_POST['FeedID'])).";
      ");
      $DestinationID = intval(Sanitize($_POST['FeedID']));
      
    }else{
      
      //New
      Query("
        INSERT INTO `FeedCategory`(
          `FeedSourceID`,
          `FeedCategoryID`,
          `FeedParserID`,
          `URL`,
          `FeedName`,
          `FeedDescription`,
          `FeedLogoURL`,
          `MinimumInterval`,
          `LastFetch`,
          `TTL`
        )VALUES(
          ".$mFeedSourceID.", 
          ".$mFeedCategoryID.", 
          ".$mFeedParserID.", 
          '".Sanitize($_POST['URL'])."', 
          '".Sanitize($_POST['FeedName'])."', 
          '".Sanitize($_POST['FeedDescription'])."', 
          '".Sanitize($_POST['FeedLogoURL'])."', 
          '".Sanitize($_POST['MinimumInterval'])."', 
          '".Sanitize($_POST['LastFetch'])."', 
          '".Sanitize($_POST['TTL'])."'
        );
      ");
      global $ASTRIA;
      $DestinationID = mysqli_insert_id($ASTRIA['databases']['astria']['resource']);
    }
    
    header('Location: /architect/feedsync/feed/'.$DestinationID);
    exit;
  }
  
  TemplateBootstrap4('Feed - FeedSync','FeedSyncFeedPageBodyCallback();');
}
function FeedSyncFeedPageBodyCallback(){
  include_once('Category.php');
  $FeedID = intval(path(3));
  
  //TODO false should probably show a list of feeds instead of creating a new feed
  if(
    $FeedID == 'add'||
    $FeedID == false
  ){
    FeedSyncFeedNew();
  }else{
    $Feed = Query('SELECT * FROM Feed WHERE FeedID LIKE '.$FeedID);
    if(count($Feed)==0){
      ?>
      <h1><a href="/architect/feedsync">FeedSync</a> - Category Not Found</h1>
      <?php
      exit;
    }else{
      $Feed = $Feed[0];
      FeedSyncFeedEdit($Feed);
    }
  }
  
}
function FeedSyncFeedEdit($Feed){
  ?>
  <h1><a href="/architect/feedsync">FeedSync</a> - Feed Editor</h1>
  <?php
  
  $Editable = array(
    'FeedSourceID'    => $Feed['FeedSourceID'],
    'FeedCategoryID'  => $Feed['FeedCategoryID'],
    'FeedParserID'    => $Feed['FeedParserID'],
    'URL'             => $Feed['URL'],
    'FeedName'        => $Feed['FeedName'],
    'FeedDescription' => $Feed['FeedDescription'],
    'FeedLogoURL'     => $Feed['FeedLogoURL'],
    'MinimumInterval' => $Feed['MinimumInterval'],
    'LastFetch'       => $Feed['LastFetch'],
    'TTL'             => $Feed['TTL']
  );
  $Readable = array(
    'FeedID' => $Feed['FeedID']
  );
  $Hidden = $Readable;
  
  echo AstriaBootstrapAutoForm(
    $Editable,
    $Readable,
    $Hidden
  );
  
}
function FeedSyncFeedNew(){
  ?>
  <h1><a href="/architect/feedsync">FeedSync</a> - Feed Editor - New</h1>
  <?php
  
  $Editable = array(
    'FeedSourceID'    => $Feed['FeedSourceID'],
    'FeedCategoryID'  => $Feed['FeedCategoryID'],
    'FeedParserID'    => $Feed['FeedParserID'],
    'URL'             => $Feed['URL'],
    'FeedName'        => $Feed['FeedName'],
    'FeedDescription' => $Feed['FeedDescription'],
    'FeedLogoURL'     => $Feed['FeedLogoURL'],
    'MinimumInterval' => $Feed['MinimumInterval'],
    'LastFetch'       => $Feed['LastFetch'],
    'TTL'             => $Feed['TTL']
  );
  
  echo AstriaBootstrapAutoForm(
    $Editable
  );
}
