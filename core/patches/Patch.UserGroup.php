<?php

Hook('Run Astria Patches','PatchUserGroupTableAddColumns();');

function PatchUserGroupTableAddColumns(){
  Event('Patch: Looking for columns that need to be added to the User table.');
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'UserGroup'
    AND column_name = 'Eponym';
  ");
  if($Check[0]['Check']==0){
    Event('Adding Eponym Column');
    Query("ALTER TABLE `UserGroup` ADD `Eponym` VARCHAR(255) NOT NULL AFTER `Description`;");
  }else{
    Event('Eponym column already exists');
  }
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'UserGroup'
    AND column_name = 'UserInserted';
  ");
  if($Check[0]['Check']==0){
    Event('Adding UserInserted Column');
    Query("ALTER TABLE `UserGroup` ADD `UserInserted` INT NOT NULL AFTER `Eponym`, ADD `TimeInserted` DATETIME NOT NULL AFTER `UserInserted`, ADD `UserUpdated` INT NULL AFTER `TimeInserted`, ADD `TimeUpdated` DATETIME NULL AFTER `UserUpdated`;");
  }else{
    Event('UserInserted column already exists');
  }
}
