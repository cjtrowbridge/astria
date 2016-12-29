<?php

function ArchitectNewView(){
  if(isset($_POST['newViewName'])){
    global $ASTRIA;
    
    $newViewName         = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_POST['newViewName']);
    $newViewDescription  = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_POST['newViewDescription']);
    $newViewNameSlug     = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_POST['newViewNameSlug']);

    $sql="INSERT INTO `View` (`Slug`, `Name`, `Description`) VALUES ('".$newViewNameSlug."', '".$newViewName."', '".$newViewDescription."');";
    die($sql);
    Query($sql);
    $ViewID=mysqli_insert_id($ASTRIA['databases']['astria core administrative database']['resource']);
    
    header('Location: /architect/edit-view/'.$ViewID);
    exit;
    
  }
}
