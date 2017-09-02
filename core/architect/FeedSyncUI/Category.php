<?php

function FeedSyncCategoryPage(){
  
  
  
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
}
