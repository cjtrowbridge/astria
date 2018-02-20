<?php

Hook('Run Astria Patches','PatchGroupsToUserGroups();');
function PatchGroupsToUserGroups(){
  Event('Patch: Making sure user groups table has been renamed from group.');
  
  global $ASTRIA;
  $DBName = $ASTRIA['databases']['astria']['database'];
  $TableExists = Query("SELECT count(*) as 'Found' FROM information_schema.tables WHERE table_schema = '$DBName' AND table_name = 'UserGroup';");
  if($TableExists[0]['Found']==0){
    Query("ALTER TABLE `Group` RENAME `UserGroup`;");
  }
  
  Event('Patch Done: Making sure user groups table has been renamed from group.');
}
