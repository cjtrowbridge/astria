<?php


/*

This is a problem I have tried to solve lots of times in the past, to varying degrees of success.

The plan this time is that there is a table which includes the UserID (indexed) and the name of a permission they have. When a user logs in, all the permissions they have are loaded into an array inside the user object which is saved in the session. There is also an array loaded which contains all known permissions.

Whenever the HasPermission function is called, the array is searched for a match which returns true or false. This way the database only needs to be queried once when a user logs in. This can be further cached later.

Also whenever the HasPermission function is called, if the permission specified is not listed in the array of all known permissions, the permission is added to the database under UserID 0 which is simply the list of all possible permissions.

I think this is a very good system which will scale much better than my previous attempts did

*/


function HasPermission($Permission){
  //check if the permission exists within the user's list of permissions
  global $ASTRIA;
  if(!isset($ASTRIA['Session'])){return false;}
  if(!isset($ASTRIA['Session']['User'])){return false;}
  if(!isset($ASTRIA['Session']['User']['Permission'])){return false;}
  if(!isset($ASTRIA['Session']['User']['UserID'])){return false;}

  //if yes, return true;
  if(isset($ASTRIA['Session']['User']['Permission'][$Permission])){return true;}
  
  //check if the permission is in the list of all possible permissions
  //if yes, return false;
  if(isset($ASTRIA['Session']['AllPermissions'][$Permission])){return false;}
  
  //add it to the database under user 0.
  $SQL = "INSERT IGNORE INTO Permission (`UserID`,`Text`)VALUES(".intval($ASTRIA['Session']['User']['UserID']).",'".Sanitize($Permission)."')";
  pd($SQL);
  Query($SQL); 
     
  //reload the user's list of permissions.
  LoadUserPermissionsIntoSession();
  
  return false;
}

function LoadUserPermissionsIntoSession(){
  global $ASTRIA;
  
  if(!isset($ASTRIA['Session'])){return false;}
  if(!isset($ASTRIA['Session']['User'])){return false;}
  if(!isset($ASTRIA['Session']['User']['UserID'])){return false;}
  
  $UserID = $ASTRIA['Session']['User']['UserID'];
  
  //Get relevant permissions
  $Permissions = Query("SELECT * FROM Permission WHERE Text NOT NULL AND UserID = 0 OR UserID = ".$UserID);
  
  $ASTRIA['Session']['AllPermissions']  = array();
  $ASTRIA['Session']['User']['Permissions'] = array();
  
  foreach($Permissions as $Permission){
    if($Permission['UserID']==0){
      $ASTRIA['Session']['AllPermissions'][$Permission['Text']]=$Permission['Text'];
    }else{
      $ASTRIA['Session']['User']['Permissions'][$Permission['Text']]=$Permission['Text'];
    }
  }
  
  
  //save session
  AstriaSessionSave();

}
