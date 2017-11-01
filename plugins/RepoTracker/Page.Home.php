<?php

function RepoTracker_Homepage(){
  TemplateBootstrap4('RepoTracker','RepoTracker_Homepage_BodyCallback();');
}

function RepoTracker_Homepage_BodyCallback(){
  ?><h1><a href="/repotracker">RepoTracker</a></h1>
  <a class="btn btn-success" href="/repotracker/refresh">Refresh</a>


<div class="row">
  <div class="col-xs-12">
    <h4>Tracked Repositories</h4>
    <?php 
      $Repos = Query("SELECT * FROM `Repository`");
      foreach($Repos as $Repo){
        echo '<p><a href="">'.str_replace($_SERVER['DOCUMENT_ROOT'],'',$Repo['Path']).'</a>';
        
        if( $Repo['BleedingEdge'] == 1 ){
          echo ' <b>Bleeding Edge</b>';
        }
        
        echo '</p>';
      }
  
      echo ArrTabler($Repos); 
    ?>
  </div>
</div>

<?php
  
  
}
