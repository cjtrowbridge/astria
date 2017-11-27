<?php

Hook('User Is Logged In','RepoTracker_MaybeCheckForUpdates();');
Hook('Architect Homepage','RepoTracker_CheckForUpdates();');

function RepoTracker_MaybeCheckForUpdates(){
  if(isset($_GET['RepoTrackerCheckForUpdates'])){
    if(
      IsAstriaAdmin()
    ){
      RepoTracker_CheckNowForUpdates();
      exit;
    }else{
      die('You do not have permission to check for updates with RepoTracker. ');
    }
  }
}

function RepoTracker_CheckForUpdates(){
  ?>
<div class="card">
  <div class="card-block">
    <div class="card-text">
      <h4><a href="/repotracker">RepoTracker</a> - Updates</h4>
      <p id="RepoTrackerUpdatesChecker">Checking...<img src="/img/ajax-loader.gif" title="Checking With RepoTracker For Updates..."></p>
      <script>
        $.get("/?RepoTrackerCheckForUpdates",function(data){
          $('#RepoTrackerUpdatesChecker').html(data);
        });
      </script>
    </div>
  </div>
</div>
  <?php
}

function RepoTracker_CheckNowForUpdates(){
  
  $AvailableUpdates = Query("SELECT COUNT(*) AS 'Updates' FROM Repository WHERE LocalHash NOT LIKE RemoteHash;");
  
  if($AvailableUpdates[0]['Updates']>0){
    ?>
      Updates Available! <a href="/repotracker" class="btn btn-danger">Update Now</a>
    <?php
  }else{
    ?>
      <p>Checked already today. Everything is up to date. <i class="material-icons" title="Up To Date">done</i></p>
      <a href="/repotracker/refresh" class="btn btn-success">Check Again</a>
    <?php
  }
  
}
