<?php
/*
Hook('Run Astria Patches','PatchUserGroupMembershipTableAddColumns();');

function PatchUserGroupMembershipTableAddColumns(){
  Event('Patch: Looking for columns that need to be added to the UserGroupMembership table.');

  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'UserGroupMembership'
    AND column_name = 'UserInserted';
  ");
  if($Check[0]['Check']==0){
    Event('Adding UserInserted Column');
    Query("ALTER TABLE `UserGroupMembership` ADD `UserInserted` INT NOT NULL AFTER `GroupID`, ADD `TimeInserted` DATETIME NOT NULL AFTER `UserInserted`, ADD `UserUpdated` INT NULL AFTER `TimeInserted`, ADD `TimeUpdated` DATETIME NULL AFTER `UserUpdated`;");
  }else{
    Event('UserInserted column already exists');
  }
}
*/
