<?php

function RepoTracker_Refresh(){
  TemplateBootstrap4('Refresh - RepoTracker','RepoTracker_Refresh_BodyCallback();');
}

function RepoTracker_Refresh_BodyCallback(){
  ?><h1><a href="/repotracker">RepoTracker</a> - Refresh</h1>

  <ul>
    <li>Looking for new repositories...     <br> <?php RepoTrackerRefresh(true); ?></li>
    <li>Confirming Local Hashes...          <br> </li>
    <li>Confirming remote Hashes...         <br> </li>
    <li>Pulling Bleeding Edges...           <br> </li>
    <li>Done.</li>
  </ul>

<?php
  
  
}
