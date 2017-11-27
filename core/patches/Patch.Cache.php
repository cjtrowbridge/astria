<?php
Hook('Run Astria Patches','PatchSchemaCacheTable();');

function PatchSchemaCacheTable(){
  Event('Patch: Looking for SchemaMeta table.');
  
  $Check = Query("SELECT DATA_TYPE FROM `information_schema`.`columns` WHERE TABLE_SCHEMA LIKE 'astria.io' AND TABLE_NAME LIKE 'Cache' AND COLUMN_NAME LIKE 'Content'");
  if($Check[0]['DATA_TYPE']=='text'){
    Event('Updating Cache content from text to longtext');
    Query("ALTER TABLE `Cache` CHANGE `Content` `Content` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;");
  }else{
    Event('Cache content is already longtext');
  }
}




