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


function FindGitRepositoriesRecursive($Path = false){
  if($Path==false){
    $Path = $_SERVER['DOCUMENT_ROOT'];
  }
  
  $Temp = array();
  
  if(is_dir($Path.DIRECTORY_SEPARATOR.'.git')){
    $Temp[$Path] = $Path;
    echo '<p>Y: '.$Path.'</p>';
  }else{
    
  }
     
  if($Handle = opendir( $Path )){
    while (false !== ($File = readdir( $Handle ))){
      $FullPath = $Path .DIRECTORY_SEPARATOR. $File;
      if( $File != "." && $File != ".." && $File != ".git" && is_dir( $FullPath )){
        $Temp2 = FindGitRepositoriesRecursive($FullPath);
        echo '<p>Combining: ';
        pd($Temp);
        pd($Temp2);
        $Temp = array_combine($Temp, $Temp2);
        echo '</p>';
      }
    }
    closedir($Handle);
  }

  
  return $Temp;
}
