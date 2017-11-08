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
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'User'
    AND column_name = 'TimeUpdated';
  ");
  if($Check[0]['Check']==0){
    Event('Adding User UserInsertedColumn');
    Query("ALTER TABLE `User` ADD `UserInserted` INT NULL;");
    Query("ALTER TABLE `User` ADD `TimeInserted` DATETIME NULL;");
    Query("ALTER TABLE `User` ADD `UserUpdated` INT NULL;");
    Query("ALTER TABLE `User` ADD `TimeUpdated` DATETIME NULL;");
  }else{
    Event('User UserInserted column already exists');
  }
  
  //Need to update the first user to still be an admin
  //This assumes the first user will always be an admin
  Query("UPDATE User SET IsAstriaAdmin = TRUE, IsWaiting = FALSE WHERE UserID = 1;");
  
  
  Event('Patch: Done looking for columns that need to be added to the User table.');
  
  
}
