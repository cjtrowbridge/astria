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
    $Output.= ArchitectShowViewCategoryTreeReturnTreeViews($Element['ViewCategoryID']);
    foreach($DirectChildren as $DirectChild){
      $Output.= ArchitectShowViewCategoryTreeReturnTreeElement($DirectChild,$Elements);
    }
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
     $Ret.="  <li><a href=\"".$View['Slug']."\">".$View['Name']."</a> (<a href=\"/architect/edit-view/".$View['ViewID']."\">edit</a>)</li>\n";
  }
  return $Ret;
}
