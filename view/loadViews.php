<?php

function LoadViews(){
  MakeSureDBConnected(); 
  //find views with slug matching output of url() function and group same as user
  $sql="
    SELECT * FROM View
    LEFT JOIN Hook on Hook.ViewID = View.ViewID
    LEFT JOIN Callback on Hook.CallbackID = Callback.CallbackID
    WHERE
      (
        View.Slug LIKE '".mysql_real_escape_string(url())."' OR
        View.ViewID = ".intval(mysql_real_escape_string(path(0)))."
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
