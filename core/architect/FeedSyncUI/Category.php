<?php

function FeedSyncCategoryPage(){
  
  
  
  TemplateBootstrap4('Category - FeedSync','FeedSyncCategoryPageBodyCallback();');
}


function FeedSyncCategoryPageBodyCallback(){
  $CategoryID = Sanitize(path(3));
  if($CategoryID == 'add'){
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
  
  pd($Category);
  $Editable = array(
    $Category['Name'],
    $Category['Description'],
    $Category['Path'],
    $Category['ParentID']
  );
  $Readable = array(
    $Category['FeedCategoryID'];
  );
  $Hidden = $Readable;
  
  echo AstriaBootstrapAutoForm(
    $Editable,
    $Readable,
    $Hidden
  );
}

function FeedSyncCategoryNew($Category){
  pd($Category);
  
  //AstriaBootstrapAutoForm($Editable,$Readable = array(),$Hidden = array());
}
