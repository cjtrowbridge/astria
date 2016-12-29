<?php

function ArchitectNewView(){
  if(isset($_POST['newViewName'])){
    global $ASTRIA;
    
    MakeSureDBConnected();
    
    $newViewName         = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_POST['newViewName']);
    $newViewDescription  = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_POST['newViewDescription']);
    $newViewSlug     = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_POST['newViewSlug']);

    $sql="INSERT INTO `View` (`Slug`, `Name`, `Description`) VALUES ('".$newViewSlug."', '".$newViewName."', '".$newViewDescription."');";
    Query($sql);
    $ViewID=mysqli_insert_id($ASTRIA['databases']['astria core administrative database']['resource']);
    
    header('Location: /architect/edit-view/'.$ViewID);
    exit;
    
  }
}
