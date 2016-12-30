<?php

function showArchitectViewCategory(){
  Hook('Template Body','ArchitectViewCategory();');
  TemplateBootstrap2('View Category - Architect'); 
}

function ArchitectViewCategory(){
  //TODO this should eventually work for View Category Slugs in addition to ViewCategoryIDs
  if(path(2)==intval(path(2))){
    
    //Show a specific view category
    $View=Query("SELECT * FROM ViewCategory WHERE ViewCategoryID = ".intval(path(2))."");
    ShowCategory($View);
    
  }else{
    
    //List all view categories
    ShowAllCategories();
    
  }
}

function ShowAllCategories(){
  echo ArrTabler(Query("SELECT * FROM ViewCategory"));
}

function ShowCategory($View){
   echo ArrTabler($View); 
}
