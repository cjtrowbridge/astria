<?php

function RepoTracker_Refresh(){
  TemplateBootstrap4('Refresh - RepoTracker','RepoTracker_Refresh_BodyCallback();');
}

function RepoTracker_Refresh_BodyCallback(){
  ?><h1><a href="/repotracker">RepoTracker</a> - Refresh</h1>

  <ul>
    <li>Looking for new repositories...     <br> <?php RepoTrackerRefresh(true); ?></li>
    <li>Confirming Local Hashes...          <br> <?php RepoTracker_VerifyLocalHashes(true); ?></li>
    <li>Confirming remote Hashes...         <br> <?php RepoTracker_VerifyRemoteHashes(true); ?></li>
    <li>Pulling Bleeding Edges...           <br> <?php RepoTracker_PullBleedingEdgeRepos(true); ?></li>
    <li>Done.</li>
  </ul>

<?php
  
  
}
