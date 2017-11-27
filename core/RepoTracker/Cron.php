<?php

Hook('Daily Cron','RepoTracker_CronRefresh();');
function RepoTracker_CronRefresh(){
  RepoTrackerRefresh();
  RepoTracker_VerifyLocalHashes();
  RepoTracker_PullBleedingEdgeRepos();
}
