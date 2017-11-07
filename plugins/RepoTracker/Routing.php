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
        `RemoteHash` VARCHAR(255) NULL ,  
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
  RepoTracker_PullBleedingEdgeRepos();
}

function RepoTracker_PullBleedingEdgeRepos($Verbose = false){
  $SQL = "SELECT * FROM Repository WHERE LocalHash NOT LIKE RemoteHash AND LocalHash IS NOT NULL AND LocalHash NOT LIKE '' AND BleedingEdge = 1";
  $BleedingEdgeRepos = Query($SQL);
  $Pulls = 0;
  foreach($BleedingEdgeRepos as $Repo){
    $Command = 'cd '.$Repo['Path'].' && git reset --hard && git pull';
    $Result = shell_exec($Command);
    if($Verbose){
      pd($Command);
      pd($Result);
    }
    $Pulls++;
  }
  if($Pulls>0){
    if($Verbose){
      echo '<p>Reverifying local hashes...</p>';
    }
    RepoTracker_VerifyLocalHashes();
    $New = Query($SQL);
    if(count($New)>0){
      echo '<p>FAILED TO PULL. Check permissions.</p>';
    }
  }
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

function RepoTracker_VerifyLocalHashes($Verbose = false){
  $Repos = Query("SELECT RepositoryID,Path,LocalHash FROM Repository");
  foreach($Repos as $Repo){
    $HashFile = $Repo['Path'].'/.git/refs/heads/master';
    if(file_exists($HashFile)){
      $Hash = file_get_contents($HashFile);
      $Hash = trim($Hash);
      if($Hash != $Repo['LocalHash']){
        if($Verbose){echo '<p>Updating LocalHash in database for repository: "'.$Repo['Path'].'".</p>';}
        Query('UPDATE Repository SET LocalHash = "'.Sanitize($Hash).'" WHERE RepositoryID = '.intval($Repo['RepositoryID']));
      }
    }else{
      if($Verbose){echo '<p>No master branch hash file found for repo: "'.$Repo['Path'].'".</p>';}
    }
  }
}

function RepoTracker_VerifyRemoteHashes($Verbose = false){
  $Repos = Query("SELECT RepositoryID,Path,RemoteHash FROM Repository");
  foreach($Repos as $Repo){
    $Command = 'cd '.$Repo['Path'].' && git config --get remote.origin.url';
    $Result = shell_exec($Command);
    $Result = trim($Result);
    $Result = str_replace('.git','',$Result);
    $Result = str_replace('https://github.com/','',$Result);
    $Result = 'https://api.github.com/repos/'.$Result;
    //$Result .= '/git/refs/heads/master';
    $Result .= '/branches/master';
    
    //if($Verbose){echo '<p>No master branch hash file found for repo: "'.$Repo['Path'].'".</p>';}
    
    $Result = FetchURL($Result);
    $Result = json_decode($Result,true);
    if($Result==false){continue;}
    
    //if(!(isset($Result['object']))){continue;}
    //if(!(isset($Result['object']['sha']))){continue;}
    //$Result = trim($Result['object']['sha']);
    
    if(!(isset($Result['commit']))){continue;}
    if(!(isset($Result['commit']['sha']))){continue;}
    $Result = trim($Result['commit']['sha']);
    Query('UPDATE Repository SET RemoteHash = "'.Sanitize($Result).'" WHERE RepositoryID = '.intval($Repo['RepositoryID']));
  }
}


    
