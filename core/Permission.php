<?php


/*

This is a problem I have tried to solve lots of times in the past, to varying degrees of success.

The plan this time is that there is a table which includes the UserID (indexed) and the name of a permission they have. When a user logs in, all the permissions they have are loaded into an array inside the user object which is saved in the session. There is also an array loaded which contains all known permissions.

Whenever the HasPermission function is called, the array is searched for a match which returns true or false. This way the database only needs to be queried once when a user logs in. This can be further cached later.

Also whenever the HasPermission function is called, if the permission specified is not listed in the array of all known permissions, the permission is added to the database under UserID 0 which is simply the list of all possible permissions.

I think this is a very good system which will scale much better than my previous attempts did

*/

//Whenever the session is challenged, reload permissions. This might not be necessary if performance is a concern in situations where permissions don't change often.
Hook('Challenge Session','LoadUserPermissionsIntoSession();');

function HasPermission($Permission){
  //check if the permission exists within the user's list of permissions
  global $ASTRIA;
  if(!isset($ASTRIA['Session'])){Event('Permission Negative: No Session');return false;}
  if(!isset($ASTRIA['Session']['User'])){Event('Permission Negative: No User');return false;}
  if(!isset($ASTRIA['Session']['User']['Permission'])){Event('Permission Negative: No Permissions object');return false;}
  if(!isset($ASTRIA['Session']['User']['UserID'])){Event('Permission Negative: No User ID');return false;}

  //if yes, return true;
  if(isset($ASTRIA['Session']['User']['Permission'][$Permission])){return true;}
  
  //check if the permission is in the list of all possible permissions
  //if yes, return false;
  if(isset($ASTRIA['Session']['AllPermissions'][$Permission])){
    Event('Permission Negative: We know about this and you don\'t have it.');
  
    if($ASTRIA['Session']['User']['IsAstriaAdmin']=="1"){Event('Admins have all permissions.');return true;}else{Event('User is not an astria admin.');}
  
    return false;
  }
  
  //add it to the database under user 0.
  $SQL = "INSERT IGNORE INTO Permission (`UserID`,`Text`)VALUES(0,'".Sanitize($Permission)."')";
  Query($SQL); 
     
  //reload the user's list of permissions.
  LoadUserPermissionsIntoSession();
  
  if($ASTRIA['Session']['User']['IsAstriaAdmin']=="1"){Event('Admins have all permissions.');return true;}else{Event('User is not an astria admin.');}
  
  return false;
}

function HasPermissionBeginingWith($Permission){
  //check if the permission exists within the user's list of permissions
  global $ASTRIA;
  if(!isset($ASTRIA['Session'])){Event('Permission Negative: No Session');return false;}
  if(!isset($ASTRIA['Session']['User'])){Event('Permission Negative: No User');return false;}
  if(!isset($ASTRIA['Session']['User']['Permission'])){Event('Permission Negative: No Permissions object');return false;}
  if(!isset($ASTRIA['Session']['User']['UserID'])){Event('Permission Negative: No User ID');return false;}

  if($ASTRIA['Session']['User']['IsAstriaAdmin']=="1"){Event('Admins have all permissions.');return true;}else{Event('User is not an astria admin.');}
  
  if(count(preg_grep('/^'.$Permission.'/', array_keys($ASTRIA['Session']['User']['Permission']))) > 0){return true;}
  
  return false;
}



function LoadUserPermissionsIntoSession(){
  global $ASTRIA;
  
  if(!isset($ASTRIA['Session'])){return false;}
  if(!isset($ASTRIA['Session']['User'])){return false;}
  if(!isset($ASTRIA['Session']['User']['UserID'])){return false;}
  
  $UserID = intval($ASTRIA['Session']['User']['UserID']);
  
  //Get relevant permissions
  $SQL = "SELECT * FROM Permission WHERE Text IS NOT NULL AND ( UserID = 0 OR UserID = ".$UserID.")";
  $Permissions = Query($SQL);
  
  $ASTRIA['Session']['AllPermissions']  = array();
  $ASTRIA['Session']['User']['Permission'] = array();
  
  foreach($Permissions as $Permission){
    if($Permission['UserID']==0){
      $ASTRIA['Session']['AllPermissions'][$Permission['Text']]=$Permission['Text'];
    }else{
      $ASTRIA['Session']['User']['Permission'][$Permission['Text']]=$Permission['Text'];
    }
  }
  
  Event('Done Reloading User Permissions Into Session');
  
  Event('Start loading group permissions into session.');
  
  $SQL = "
    SELECT Text FROM Permission
    LEFT JOIN UserGroupMembership ON UserGroupMembership.GroupID = Permission.GroupID
    WHERE UserGroupMembership.UserID = ".$UserID;
  $GroupPermissions = Query($SQL);
  
  foreach($GroupPermissions as $Permission){
    $ASTRIA['Session']['User']['Permission'][$Permission['Text']]=$Permission['Text'];
  }
  
  Event('Done loading group permissions into session.');
  
  
  //save session
  AstriaSessionSave();

}
