<?php

function LoadViews(){
  
  MakeSureDBConnected(); 
  $resource     = $ASTRIA['databases']['astria core administrative database']['resource'];;
  $cleanSlug    = mysqli_real_escape_string($resource,url()); 
  $cleanViewID  = intval(path(0));
  
  //find views with slug matching output of url() function and group same as user
  $sql="
    SELECT * FROM View
    LEFT JOIN Hook on Hook.ViewID = View.ViewID
    LEFT JOIN Callback on Hook.CallbackID = Callback.CallbackID
    WHERE
      (
        lower(View.Slug) LIKE 'all' OR
        View.Slug LIKE '".$cleanSlug."' OR
        View.ViewID = ".$cleanViewID."
      ) AND
      (
  ";
  foreach($_SESSION['User']['Memberships'] as $GroupID){
    $sql.="
       View.GroupID = ".$GroupID." OR
    ";
  }
 
  $sql.="
       View.GroupID = 0
     )
    ORDER BY View.ViewID ASC
  ";
  $Views=Query($sql);
 
  //attach any hooks
  foreach($Views as $View){
    Hook($View['Event'],$View['Content']);
  }
  
}
