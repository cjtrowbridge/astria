<?php

global $TREEIDENTITYINCREMENTCOUNTER;
$TREEIDENTITYINCREMENTCOUNTER=1;

function ArchitectShowViewCategoryTree(){
  MakeSureDBConnected();
  $ViewCategories = Query('SELECT * FROM `ViewCategory`');
  $Output ="  <div class=\"css-treeview\">\n";
  $Output.="    <ul>\n";
  foreach($ViewCategories as $ViewCategory){
    if($ViewCategory['ParentID'] == ''){
      $Output.=ArchitectShowViewCategoryTreeReturnTreeElement($ViewCategory,$ViewCategories);
    }
  }
  $Output.="      <li>&nbsp;</li>\n";
  $Output.="      <li><a href=\"/architect/new-view/\">New View</a></li>\n";
  $Output.="      <li><a href=\"/architect/new-view-category/\">New Category</a></li>\n";
  $Output.="      <li><a href=\"/architect/edit-view-category/".$ViewCategory['ViewCategoryID']."\">Edit Category</a></li>\n";
  $Output.="      <li>&nbsp;</li>\n";
  $Output.="    </ul>\n";  
  $Output.="  </div>\n";
  return $Output;
}

function ArchitectShowViewCategoryTreeReturnTreeElement($Element,$Elements){
  $Output ="";
  $DirectChildren = array();
  foreach($Elements as $Child){
   if($Child['ParentID']==$Element['ViewCategoryID']){
     $DirectChildren[]=$Child;
   }
  }
  
  if(true||count($DirectChildren)>0){
    global $TREEIDENTITYINCREMENTCOUNTER;
    $TREEIDENTITYINCREMENTCOUNTER+=1;
    $Output.="      <li><input type=\"checkbox\" id=\"item-".$TREEIDENTITYINCREMENTCOUNTER."\" /><label for=\"item-".$TREEIDENTITYINCREMENTCOUNTER."\" title=\"".$Element['Description']."\">".$Element['Name']."</label>\n";
    $Output.="        <ul>\n";    
    foreach($DirectChildren as $DirectChild){
      $Output.= ArchitectShowViewCategoryTreeReturnTreeElement($DirectChild,$Elements);
    }
    $Output.= ArchitectShowViewCategoryTreeReturnTreeViews($Element['ViewCategoryID']);
    $Output.="          <li>&nbsp;</li>\n";
    $Output.="          <li><a href=\"/architect/new-view/?category=".$Element['ViewCategoryID']."\">New View</a></li>\n";
    $Output.="          <li><a href=\"/architect/new-view-category/?parent=".$Element['ViewCategoryID']."\">New Category</a></li>\n";
    $Output.="          <li><a href=\"/architect/edit-view-category/".$Element['ViewCategoryID']."\">Edit Category</a></li>\n";
    $Output.="          <li>&nbsp;</li>\n";
    $Output.="        </ul>\n";
  }else{
    $Output.="          <li><a href=\"./\">".$Element['Name']."</a></li>\n";
  }
  $Output.="      </li>\n";
  return $Output;
};

function ArchitectShowViewCategoryTreeReturnTreeViews($ViewCategoryID){
  $Views = Query('SELECT * FROM `View` WHERE ViewCategoryID = '.intval($ViewCategoryID));
  if(count($Views)==0){
    return "<li>No Views Found</li>\n";
  }
  $Ret='';
  foreach($Views as $View){
     $Ret.="  <li><a href=\"/".$View['Slug']."\">".$View['Name']."</a> (<a href=\"/architect/edit-view/".$View['ViewID']."\">edit</a>)</li>\n";
  }
  return $Ret;
}
