<?php

Hook('User Is Logged In','RepoTracker_MaybeCheckForUpdates();');

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
<span id="RepoTrackerUpdatesChecker"><img src="/img/ajax-loader.gif" title="Checking With RepoTracker For Updates..."></span>
<script>
  $.get("/?RepoTrackerCheckForUpdates",function(data){
    $('#RepoTrackerUpdatesChecker').html(data);
  });
</script>

  <?php
}

function RepoTracker_CheckNowForUpdates(){
  
  $AvailableUpdates = Query("SELECT COUNT(*) AS 'Updates' FROM Repository WHERE LocalHash NOT LIKE RemoteHash;");
  
  if($AvailableUpdates[0]['Updates']>0){
    echo '<a href="/repotracker">Updates Available <i class="material-icons" title="Updates Available" style="color: red;">system_update_alt</i></a>';
  }else{
    ?><span class="small text-muted">Checked Today; Up To Date</span> <i class="material-icons" title="Up To Date">done</i><?php
  }
  
}
