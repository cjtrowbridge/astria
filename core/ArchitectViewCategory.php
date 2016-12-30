<?php

function ArchitectViewCategory(){
  //TODO this should eventually work for View Category Slugs in addition to ViewCategoryIDs
  if(path(2)==intval(path(2))){
    
    //Show a specific view category
    $View=Query("SELECT * FROM ViewCategory WHERE ViewCategoryID = ".intval(path(2))."")
    ShowCategory($View);
    
  }else{
    
    //List all view categories
    ShowAllCategories();
    
  }
}

function ShowAllCategories(){
  echo ArrTabler(Query("
    SELECT * FROM Views
  "));
}

function ShowCategory($View){
   echo ArrTabler($View); 
}
