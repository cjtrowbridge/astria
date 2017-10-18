<?php


/*

This is a problem I have tried to solve lots of times in the past, to varying degrees of success.

The plan this time is that there is a table which includes the UserID (indexed) and the name of a permission they have. When a user logs in, all the permissions they have are loaded into an array inside the user object which is saved in the session. There is also an array loaded which contains all known permissions.

Whenever the HasPermission function is called, the array is searched for a match which returns true or false. This way the database only needs to be queried once when a user logs in. This can be further cached later.

Also whenever the HasPermission function is called, if the permission specified is not listed in the array of all known permissions, the permission is added to the database under UserID 0 which is simply the list of all possible permissions.

I think this is a very good system which will scale much better than my previous attempts did

*/


function HasPermission(){
  //check if the permission exists within the user's list of permissions
  
  //if yes, return true, else;
  
  //check if the permission is in the list of all possible permissions
  
  //if yes, return false, else;
  
  //add it to the database under user 0.
  
  //reload the user's list of permissions.
  LoadUserPermissionsIntoSession();
  
  //return false
}

function LoadUserPermissionsIntoSession(){
  //load the list of all permissions this user has
  
  //load the list of all possible permissions
  
  //save session
  
}
