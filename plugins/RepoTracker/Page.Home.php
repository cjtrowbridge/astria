<?php

function RepoTracker_Homepage(){
  TemplateBootstrap4('RepoTracker','RepoTracker_Homepage_BodyCallback();');
}

function RepoTracker_Homepage_BodyCallback(){
  ?><h1><a href="/repotracker">RepoTracker</a></h1>
  <a class="btn btn-success" href="/repotracker/refresh">Refresh</a>

<div class="row">
  <div class="col-xs-12">
    <?php echo ArrTabler(Query("SELECT * FROM `Repository`")); ?>
  </div>
</div>

<?php
  
  
}
