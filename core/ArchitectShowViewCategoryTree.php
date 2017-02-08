<?php

function ArchitectShowViewCategoryTree(){
  MakeSureDBConnected();
  $ViewCategories = Query('SELECT * FROM `ViewCategory`');
  foreach($ViewCategories as $ViewCategory){
    if($ViewCategory['ParentID'] == ''){
      ArchitectShowViewCategoryTreeRootElement($ViewCategory,$ViewCategories);
    }
  }

}

function ArchitectShowViewCategoryTreeRootElement($Element,$Elements){
  echo $Element['Name'];
};
