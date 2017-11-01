<?php

function RepoTracker_Refresh(){
  TemplateBootstrap4('Refresh - RepoTracker','RepoTracker_Refresh_BodyCallback();');
}

function RepoTracker_Refresh_BodyCallback(){
  ?><h1><a href="/repotracker">RepoTracker</a> - Refresh</h1>

<?php
  RepoTrackerRefresh(true);
  
}
