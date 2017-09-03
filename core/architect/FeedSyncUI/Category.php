<?php

function FeedSyncCategoryPage(){
  if(
    isset($_POST['Name'])
  ){
      if($_POST['ParentID']==''){
        $MaybeParentID = "NULL";
      }else{
        $MaybeParentID = "'".intval(Sanitize($_POST['ParentID']))."'";
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
          `ParentID`    = '".$MaybeParentID."' 
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
  
  TemplateBootstrap4('Category - FeedSync','FeedSyncCategoryPageBodyCallback();');
}


function FeedSyncCategoryPageBodyCallback(){
  //TODO false should probably show a list of categories instead of creating a new category
  $CategoryID = Sanitize(path(3));
  if(
    $CategoryID == 'add'||
    $CategoryID == false
  ){
    FeedSyncCategoryNew();
  }else{
    $Category = Query('SELECT * FROM FeedCategory WHERE FeedCategoryID LIKE "'.$CategoryID.'" OR Name LIKE "'.$CategoryID.'"');
    if(count($Category)==0){
      ?>
      <h1><a href="/architect/feedsync">FeedSync</a> - Category Not Found</h1>
      <?php
      exit;
    }else{
      $Category = $Category[0];
      FeedSyncCategoryEdit($Category);
    }
  }
  
}

function FeedSyncCategoryEdit($Category){
  ?>
  <h1><a href="/architect/feedsync">FeedSync</a> - Category Editor</h1>
  <?php
  
  $Editable = array(
    'Name'        => $Category['Name'],
    'Description' => $Category['Description'],
    'Path'        => $Category['Path'],
    'ParentID'    => $Category['ParentID']
  );
  $Readable = array(
    'FeedCategoryID' => $Category['FeedCategoryID']
  );
  $Hidden = $Readable;
  
  echo AstriaBootstrapAutoForm(
    $Editable,
    $Readable,
    $Hidden
  );
}

function FeedSyncCategoryNew(){
  ?>
  <h1><a href="/architect/feedsync">FeedSync</a> - Category Editor - New</h1>
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
