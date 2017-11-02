<?php

function RepoTracker_Homepage(){
  if(isset($_GET['enableBleedingEdge'])){
    //TODO permissions
    Query("UPDATE Repository SET BleedingEdge = 1 WHERE RepositoryID = ".intval($_GET['enableBleedingEdge']));
    header('Location: /repotracker');
    exit;
  }
  if(isset($_GET['disableBleedingEdge'])){
    //TODO permissions
    Query("UPDATE Repository SET BleedingEdge = 0 WHERE RepositoryID = ".intval($_GET['disableBleedingEdge']));
    header('Location: /repotracker');
    exit;
  }
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
      $Temp = array();
      foreach($Repos as $Repo){
        $Path = str_replace($_SERVER['DOCUMENT_ROOT'],'',$Repo['Path']);
        $MagicWord=BlowfishEncrypt('Pull Subrepository From Github');
        $MagicPath=BlowfishEncrypt($Path); 
        if($Path == ''){$Path = '/(Astria Core)';}
        if( $Repo['BleedingEdge'] == 1 ){
          $BleedingEdge = 'Enabled (<a href="/repotracker/?disableBleedingEdge='.$Repo['RepositoryID'].'">Disable</a>)';
        }else{
          $BleedingEdge = 'Disabled (<a href="/repotracker/?enableBleedingEdge='.$Repo['RepositoryID'].'">Enable</a>)';
        }
        
        $Temp[]=array(
          'Pull Webhook'  => '<a href="/?'.urlencode($MagicWord).'='.urlencode($MagicPath).'">Astria:/'.$Path.'</a>',
          'Bleeding Edge' => $BleedingEdge
        );
        
      }
  
      echo ArrTabler($Temp); 
    ?>
  </div>
</div>

<?php
  
  
}
