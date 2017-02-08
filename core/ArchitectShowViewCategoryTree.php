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
      $Output.=ReturnTreeElement($ViewCategory,$ViewCategories);
    }
  }
  $Output.="    </ul>\n";
  $Output.="  </div>\n";
  return $Output;
}

function ReturnTreeElement($Element,$Elements){
  $Output ="";
  $DirectChildren = array();
  foreach($Elements as $Child){
   if($Child['ParentID']==$Element['ViewCategoryID']){
     $DirectChildren[]=$Child;
   }
  }
  
  if(count($DirectChildren)>0){
    global $TREEIDENTITYINCREMENTCOUNTER;
    $TREEIDENTITYINCREMENTCOUNTER+=1;
    $Output.="      <li><input type=\"checkbox\" id=\"item-".$TREEIDENTITYINCREMENTCOUNTER."\" checked=\"checked\" /><label for=\"item-".$TREEIDENTITYINCREMENTCOUNTER."\">".$Element['Name']."</label>\n";
    $Output.="        <ul>\n";    
    foreach($DirectChildren as $DirectChild){
      $Output.= ReturnTreeElement($DirectChild,$Elements);
    }
    $Output.="        </ul>\n";
  }else{
    $Output.="          <li><a href=\"./\">".$Element['Name']."</a></li>\n";
  }
  $Output.="      </li>\n";
  return $Output;
};
