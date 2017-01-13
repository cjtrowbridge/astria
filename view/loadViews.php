<?php

Hook('User Is Logged In','LoadViews();');
Hook('User Is Not Logged In','LoadViews();');

function LoadViews(){
  global $ASTRIA;
  
  MakeSureDBConnected(); 
  $resource     = $ASTRIA['databases']['astria core administrative database']['resource'];;
  $cleanSlug    = mysqli_real_escape_string($resource,url()); 
  $cleanViewID  = intval(path(0));
  
  //find views with;
  //  slug matching output of url() function or assigned to all slugs
  //  group or user matching current user or assigned to all groups or users
  $sql="
    SELECT * FROM Hook
    LEFT JOIN View on Hook.ViewID = View.ViewID
    LEFT JOIN Permission ON Permission.ViewID = View.ViewID
    WHERE
      (
        View.Slug LIKE '".$cleanSlug."' OR
        lower(View.Slug) LIKE 'all' OR
        View.ViewID = ".$cleanViewID."
      ) AND
      (
  ";
  if(isset($_SESSION['User'])){
    $sql.="
         Permission.UserID = ".intval($_SESSION['User']['UserID'])." OR
      ";
    foreach($_SESSION['User']['Memberships'] as $GroupID){
      $sql.="
         Permission.GroupID = ".$GroupID." OR
      ";
    }
  }
 
  $sql.="
       Permission.GroupID = 1
     )
    ORDER BY View.ViewID ASC
  ";
  $Views=Query($sql);
 
  //attach any hooks
  foreach($Views as $View){
    Hook($View['Event'],$View['Content']);
  }
  
}
