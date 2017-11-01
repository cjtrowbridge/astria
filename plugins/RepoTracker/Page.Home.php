<?php

function RepoTracker_Homepage(){
  TemplateBootstrap4('RepoTracker','RepoTracker_Homepage_BodyCallback();');
}

function RepoTracker_Homepage_BodyCallback(){
  ?><h1>RepoTracker</h1>
  <a class="btn btn-success" href="/repotracker/refresh">Refresh</a>

<?php
  $Repos = FindGitRepositoriesRecursive();
  
  foreach($Repos as $Repo){
    echo '<p>'.$Repo.'</p>';
  }
  
}
