<?php

function ArchitectViewCategory(){
  //TODO this should eventually work for View Slugs in addition to ViewIDs
  if(path(2)==intval(path(2))){
    
    //Show a specific view
    $View=Query("SELECT * FROM Views WHERE ViewID = ".intval(path(2))."")
    ShowAView($View);
    
  }else{
    
    //List all views 
    ShowAllViews();
    
  }
}

function ShowAllViews(){
  echo ArrTabler(Query("
    SELECT * FROM Views
  "));
}

function ShowAView($View){
   echo ArrTabler($View); 
}
