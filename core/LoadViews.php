<?php

Hook('User Is Logged In','LoadViews();');
Hook('User Is Not Logged In','LoadViews();');

function LoadViews(){
  global $ASTRIA;
  
  MakeSureDBConnected(); 
  $resource     = $ASTRIA['databases']['astria']['resource'];;
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
  if(isset($ASTRIA['Session']['User'])){
    $sql.="
         Permission.UserID = ".intval($ASTRIA['Session']['User']['UserID'])." OR
      ";
    foreach($ASTRIA['Session']['User']['Memberships'] as $GroupID){
      $sql.="
         Permission.GroupID = ".$GroupID." OR
      ";
    }
  }
 
  $sql.="
       Permission.GroupID = 0
     )
    ORDER BY View.ViewID ASC
  ";
  $Views=Query($sql,60);
 
  //attach any hooks
  foreach($Views as $View){
    Hook($View['Event'],base64_decode($View['Content']));
  }
  
}
