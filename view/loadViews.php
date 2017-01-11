<?php

Hook('Before Checking If User Is Logged In','LoadViews();');
Hook('User Is Logged In','LoadViews();');

function LoadViews(){
  
  MakeSureDBConnected(); 
  $resource     = $ASTRIA['databases']['astria core administrative database']['resource'];;
  $cleanSlug    = mysqli_real_escape_string($resource,url()); 
  $cleanViewID  = intval(path(0));
  
  //find views with;
  //  slug matching output of url() function or assigned to all slugs
  //  group or user matching current user or assigned to all groups or users
  $sql="
    SELECT * FROM View
    LEFT JOIN Hook on Hook.ViewID = View.ViewID
    LEFT JOIN Callback on Hook.CallbackID = Callback.CallbackID
    WHERE
      (
        View.Slug LIKE '".$cleanSlug."' OR
        lower(View.Slug) LIKE 'all' OR
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
       View.GroupID = 0 OR
       View.GroupID IS NULL
     )
    ORDER BY View.ViewID ASC
  ";
  $Views=Query($sql);
 
  //attach any hooks
  foreach($Views as $View){
    Hook($View['Event'],$View['Content']);
  }
  
}
