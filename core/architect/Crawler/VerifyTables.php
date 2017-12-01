<?php

function Architect_Crawler_VerifyTables(){
  $Check = Query("SELECT COUNT(*) as 'Check' FROM information_schema.columns WHERE table_name = 'Crawler';");
  if($Check[0]['Check']==0){
    Event('Adding Crawler table');
    Query("CREATE TABLE `Crawler` ( `CrawlerID` INT NOT NULL AUTO_INCREMENT , `Name` VARCHAR(255) NULL , `Description` TEXT NULL , `Protocol` VARCHAR(255) NOT NULL , `Domain` VARCHAR(255) NOT NULL , `Path` VARCHAR(255) NOT NULL , `Query` VARCHAR(255) NOT NULL , `Variables` LONGTEXT NULL , `UserInserted` INT NOT NULL , `TimeInserted` DATETIME NOT NULL , `UserUpdated` INT NULL , `TimeUpdated` DATETIME NULL , PRIMARY KEY (`CrawlerID`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;");
  }
}
