<?php

Hook('Run Astria Patches','PatchRepositoryTableAddColumns();');

function PatchRepositoryTableAddColumns(){
  Event('Patch: Looking for columns that need to be added to the User table.');
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'Repository'
    AND column_name = 'LastChecked';
  ");
  if($Check[0]['Check']==0){
    Event('Adding Repository LastChecked column');
    Query("ALTER TABLE `Repository` ADD `LastChecked` DATETIME NULL;");
  }else{
    Event('Repository LastChecked column already exists');
  }
}
