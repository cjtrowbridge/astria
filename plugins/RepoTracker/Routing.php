<?php

Hook('User Is Logged In','RepoTrackerLoad();');

function RepoTrackerLoad(){
  if(HasPermission('RepoTracker')){
    Hook('User Is Logged In - Presentation','RepoTrackerRouting();');
  }
}

function RepoTrackerRouting(){
  if(path(0)=='repotracker'){
    
    RepoTracker_VerifyTables();
    
    switch(path(1)){
      case false:
        include_once('plugins/RepoTracker/Page.Home.php');
        RepoTracker_Homepage();
        break;
    }
  }
}

function RepoTracker_VerifyTables(){
  $Check = Query("
    SELECT COUNT(*) as 'Check'
    FROM information_schema.columns 
    WHERE table_name = 'Repository';
  ");
  if($Check[0]['Check']==0){
    Query("
      CREATE TABLE ``Repository` ( 
        `RepositoryID` INT NOT NULL AUTO_INCREMENT , 
        `Path` VARCHAR(255) NOT NULL , 
        `LocalHash` VARCHAR(255) NULL , 
        `LocalHashLastChecked` DATETIME NULL , 
        `RemoteHash` VARCHAR(255) NULL , 
        `RemoteHashLastChecked` DATETIME NULL , 
        `BleedingEdge` BOOLEAN NOT NULL DEFAULT FALSE , 
        PRIMARY KEY (`RepositoryID`), 
        INDEX (`Path`), 
        INDEX (`RemoteHashLastChecked`), 
        INDEX (`LocalHashLastChecked`)
      ) ENGINE = InnoDB;
    ");
  }
}
