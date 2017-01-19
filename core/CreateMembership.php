<?php

function CreateMembership($UserID,$GroupID){

  if(
    (intval($UserID)==0)||
    (intval($GroupID)==0)
  ){
    //TODO make this more graceful
    die('Invalid Group or User ID');
  }
  
  Query("INSERT INTO `UserMembership` (`UserID`, `GroupID`) VALUES ('".intval($UserID)."', '".intval($GroupID)."');");
  
}
