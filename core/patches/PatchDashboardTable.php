<?php

Hook('Run Astria Patches','PatchDashboardTable();');

function PatchDashboardTable(){
  Event('Patch: Looking for Dashboard table.');
  
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'Dashboard';
  ");
  if($Check[0]['Check']==0){
    Event('Adding Dashboard Table');
    Query("
      CREATE TABLE `Dashboard` ( 
        `DashboardID` INT NOT NULL AUTO_INCREMENT , 
        `Name` VARCHAR(255) NOT NULL , 
        `Description` TEXT NOT NULL , 
        `Route` VARCHAR(255) NULL ,
        `Code` LONGTEXT NOT NULL , 
        `UserInserted` INT NOT NULL , 
        `TimeInserted` DATETIME NOT NULL , 
        `UserUpdated` INT NULL , 
        `TimeUpdated` DATETIME NULL , 
        PRIMARY KEY (`DashboardID`)
      ) ENGINE = InnoDB;
    ");
  }else{
    Event('Dashboard table exists already');
  }
  
}
