<?php

Hook('Run Astria Patches','PatchUserTableAddColumns();');

function PatchUserTableAddColumns(){

  Event('Patch: Looking for columns that need to be added to the User table.');
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'User'
    AND column_name = 'IsAstriaAdmin';
  ");
  if($Check[0]['Check']==0){
    Event('Adding IsAstriaAdmin column');
    Query("ALTER TABLE `User` ADD `IsAstriaAdmin` BOOLEAN NOT NULL DEFAULT FALSE;");
  }else{
    Event('IsAstriaAdmin column already exists');
  }
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'User'
    AND column_name = 'IsWaiting';
  ");
  if($Check[0]['Check']==0){
    Event('Adding IsWaiting column');
    Query("ALTER TABLE `User` ADD `IsWaiting` BOOLEAN NOT NULL DEFAULT TRUE;");
  }else{
    Event('IsWaiting column already exists');
  }
  
  //Need to update the first user to still be an admin
  //This assumes the first user will always be an admin
  Query("UPDATE User SET IsAstriaAdmin = TRUE, IsWaiting = FALSE WHERE Email LIKE '".$cleanEmail."';");
  
  
  Event('Patch: Done looking for columns that need to be added to the User table.');
  
  
}
