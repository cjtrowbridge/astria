<?php

Hook('User Is Logged In','RepoTrackerLoad();');

function RepoTrackerLoad(){
  if(HasPermission('RepoTracker')){
    Hook('User Is Logged In - Presentation','RepoTrackerRouting();');
    Hook('Architect Tools 1','RepoTracker_ArchitectButton();');
  }
}

function RepoTracker_ArchitectButton(){
  ?>
  <a class="btn btn-outline-success" href="/repotracker/"><i class="material-icons">system_update_alt</i> Repo Tracker</a>
  <?php
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
      CREATE TABLE `Repository` ( 
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


function FindGitRepositoriesRecursive($Path = '.'){
  $Temp = array();
  if($handle = opendir($Path)){
    while (false !== ($File = readdir($handle))){
      $FullPath = $Path . DIRECTORY_SEPARATOR . $File;
      
      if(is_dir($FullPath.DIRECTORY_SEPARATOR.'.git')){
        $Temp[] = $FullPath; 
      }
      
      if( $File != "." && $File != ".." && is_dir($FullPath)){
        $Temp += FindGitRepositoriesRecursive( $FullPath );
      }
      
    }
    closedir($handle);
  }
  return $Temp;
}
