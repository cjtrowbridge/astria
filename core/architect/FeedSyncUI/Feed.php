<?php

function FeedSyncFeedPage(){
  if(
    isset($_POST['Name'])
  ){
      if($_POST['ParentID']==''){
        $MaybeParentID = "NULL";
      }else{
        $MaybeParentID = "'".intval($_POST['ParentID'])."'";
      }
    
    //Something being submitted
    //But is it a new or an update?
    
    if(isset($_POST['FeedCategoryID'])){
      
      //Update
      Query("
        UPDATE `FeedCategory` SET 
          `Name`        = '".Sanitize($_POST['Name'])."', 
          `Description` = '".Sanitize($_POST['Description'])."', 
          `Path`        = '".Sanitize($_POST['Path'])."', 
          `ParentID`    = ".$MaybeParentID."
        WHERE `FeedCategory`.`FeedCategoryID` = ".intval(Sanitize($_POST['FeedCategoryID'])).";
      ");
      $DestinationID = intval(Sanitize($_POST['FeedCategoryID']));
      
    }else{
      
      //New
      Query("
        INSERT INTO `FeedCategory`(
          `Name`, 
          `Description`, 
          `Path`, 
          `ParentID`
        )VALUES(
          '".Sanitize($_POST['Name'])."', 
          '".Sanitize($_POST['Description'])."', 
          '".Sanitize($_POST['Path'])."', 
          ".$MaybeParentID."
        );
      ");
      global $ASTRIA;
      $DestinationID = mysqli_insert_id($ASTRIA['databases']['astria']['resource']);
    }
    
    header('Location: /architect/feedsync/category/'.$DestinationID);
    exit;
  }
  
  TemplateBootstrap4('Feed - FeedSync','FeedSyncFeedPageBodyCallback();');
}
function FeedSyncFeedPageBodyCallback(){
  $FeedID = intval(path(3));
  
  //TODO false should probably show a list of feeds instead of creating a new feed
  if(
    $FeedID == 'add'||
    $FeedID == false
  ){
    FeedSyncCategoryNew();
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
    'FeedSourceID'    => $Category['FeedSourceID'],
    'FeedCategoryID'  => $Category['FeedCategoryID'],
    'FeedParserID'    => $Category['FeedParserID'],
    'URL'             => $Category['URL'],
    'FeedName'        => $Category['FeedName'],
    'FeedDescription' => $Category['FeedDescription'],
    'FeedLogoURL'     => $Category['FeedLogoURL'],
    'MinimumInterval' => $Category['MinimumInterval'],
    'LastFetch'       => $Category['LastFetch'],
    'TTL'             => $Category['TTL']
  );
  $Readable = array(
    'FeedID' => $Category['FeedID']
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
    'Name'        => '',
    'Description' => '',
    'Path'        => '',
    'ParentID'    => ''
  );
  
  echo AstriaBootstrapAutoForm(
    $Editable
  );
  ?>
  <script>
    $("#Name").change(function(){
      var NewPath = $("#Name").val();
      
      NewPath = NewPath.toLowerCase();
      NewPath = NewPath.replace(' ','-');
      
      $("#Path").val(NewPath);
    });
  </script>
  <?php
}
