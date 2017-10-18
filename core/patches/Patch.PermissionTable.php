<?php

Hook('Run Astria Patches','PatchPermissionTableAddText();');

function PatchPermissionTableAddText(){
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'Permission'
    AND column_name = 'Text';
  ");
  if($Check[0]['Check']==0){
    Event('Adding Text column to Permission table');
    Query("ALTER TABLE `Permission` ADD `Text` VARCHAR(255) NULL AFTER `GroupID`;");
    Query("ALTER TABLE `Permission` ADD UNIQUE(`UserID`,`Text`);");
  }else{
    Event('Permission table already contains Text');
  }
  
  
  
}
