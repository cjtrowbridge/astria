<?php

function RepoTracker_Homepage(){
  TemplateBootstrap4('RepoTracker','RepoTracker_Homepage_BodyCallback();');
}

function RepoTracker_Homepage_BodyCallback(){
  global $ASTRIA;
  ?><h1><a href="/repotracker">RepoTracker</a></h1>
  <a class="btn btn-success" href="/repotracker/refresh">Refresh</a>


<div class="row">
  <div class="col-xs-12">
    <h4>Tracked Repositories</h4>
    <?php 
      $Repos = Query("SELECT * FROM `Repository`");
      foreach($Repos as $Repo){
        $Path = str_replace($_SERVER['DOCUMENT_ROOT'],'',$Repo['Path']);
        
        echo '<p><a href="/?';
        
        
        $MagicWord=BlowfishEncrypt('Pull Subrepository From Github');
        $MagicPath=BlowfishEncrypt($Path); 
        echo urlencode($MagicWord).'='.urlencode($MagicPath);
        
        if($Path == ''){
          $Path = 'Astria';
        }
        echo '">'.$Path.'</a>';
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
