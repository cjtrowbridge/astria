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
      case 'refresh':
        include('Page.Refresh.php');
        RepoTracker_Refresh();
        break;
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


function FindGitRepositoriesRecursive($Path = false){
  if($Path==false){
    $Path = $_SERVER['DOCUMENT_ROOT'];
  }
  
  $Temp = array();
  
  if(is_dir($Path.DIRECTORY_SEPARATOR.'.git')){
    $Temp[] = $Path;
  }
     
  if($Handle = opendir( $Path )){
    while (false !== ($File = readdir( $Handle ))){
      $FullPath = $Path .DIRECTORY_SEPARATOR. $File;
      if( $File != "." && $File != ".." && $File != ".git" && is_dir( $FullPath )){
        $Temp2 = FindGitRepositoriesRecursive($FullPath);
        
        if(is_array($Temp2) && count($Temp2)>0){
          $Temp = array_merge($Temp, $Temp2);
        }
        
      }
    }
    closedir($Handle);
  }

  return $Temp;
}


Hook('Hourly Cron','RepoTracker_CronRefresh();');

function RepoTracker_CronRefresh(){
  RepoTrackerRefresh();
  RepoTracker_VerifyLocalHashes();
  
}

function RepoTrackerRefresh($Verbose = false){
  $Repos = FindGitRepositoriesRecursive();
  
  foreach($Repos as $Repo){
    $Check = Query("SELECT COUNT(*) as 'Count' FROM Repository WHERE Path LIKE '".Sanitize($Repo)."'");
    if($Check[0]['Count']==0){
      if($Verbose){echo '<p>Found a repo not in database. Adding "'.$Repo.'"...</p>';}
      Query("INSERT INTO Repository (`Path`)VALUES('".Sanitize($Repo)."');");
    }
  }
}

function RepoTracker_VerifyLocalHashes(){
  $Repos = Query("SELECT Path,LocalHash FROM Repository");
  foreach($Repos as $Repo){
    $Hash = file_get_contents($Repo['Path'].'/.git/refs/heads/master');
    if($Hash != $Repo['LocalHash']){
      if($Verbose){echo '<p>Updating LocalHash in database for repository: "'.$Repo['Path'].'".</p>';}
      Query('UPDATE Repository SET LocalHash = "'.Sanitize($Hash).'" WHERE RepositoryID = '.intval($Repo['RepositoryID']));
    }
    
  }
}
