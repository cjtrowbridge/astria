<?php

function ArchitectEditView(){
  Hook('Template Body','ArchitectEditViewBodyCallback();');
  TemplateBootstrap2('Architect'); 
}
function ArchitectEditViewBodyCallback(){
  global $ASTRIA;
  MakeSureDBConnected();
  
  if(is_integer(path(2))){
    //look up by id
    $View=Query("
      SELECT * FROM View 
      LEFT JOIN Hook ON Hook.ViewID = View.ViewID
      LEFT JOIN Callback.CallbackID = Hook.CallbackID
      WHERE View.ViewID = ".intval(path(2))."
    ");
  }else{
    //try looking up by slug
    $safeslug=mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],path(2));
    $View=Query("
      SELECT * FROM View 
      LEFT JOIN Hook ON Hook.ViewID = View.ViewID
      LEFT JOIN Callback.CallbackID = Hook.CallbackID
      WHERE View.Slug LIKE '".$safeslug."'
    ");
  }
  pd($View);
  
  
}
