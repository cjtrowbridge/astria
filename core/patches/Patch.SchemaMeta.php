<?php

Hook('Run Astria Patches','PatchSchemaMetaTable();');

function PatchSchemaMetaTable(){
  Event('Patch: Looking for SchemaMeta table.');
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'SchemaMeta';
  ");
  if($Check[0]['Check']==0){
    Event('Adding SchemaMeta table');
    Query("CREATE TABLE `astria.io`.`SchemaMeta` ( `SchemaMetaID` INT NOT NULL AUTO_INCREMENT , `Database` VARCHAR(255) NOT NULL , `Table` VARCHAR(255) NOT NULL , `Column` VARCHAR(255) NOT NULL , `Description` VARCHAR(255) NULL , `UserInserted` INT NOT NULL , `TimeInserted` DATETIME NOT NULL , `UserUpdated` INT NULL , `TimeUpdated` DATE NULL , PRIMARY KEY (`SchemaMetaID`)) ENGINE = InnoDB;
");
  }else{
    Event('SchemaMeta table already exists');
  }
}
