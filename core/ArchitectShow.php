<?php

function showArchitect(){
  Hook('Template Body','ArchitectBodyCallback();');
  TemplateBootstrap4('Architect'); 
}
  
function ArchitectBodyCallback(){
  global $EVENTS, $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $DEBUG, $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE,$ASTRIA;
  ?>
<h1>Architect <a href="/architect/config" target="_blank" style="float: right;"><i class="material-icons">settings</i></a></h1>
<div class="row">
  <div class="col-xs-12">
    <form class="form-inline">
      <button onclick="document.location='/architect/schema'" type="button" class="btn btn-outline-warning">Schema</button>
      <button onclick="Cardify('Events','debugSummary');" type="button" class="btn btn-outline-warning">Events</button>
      <button onclick="Cardify('Hooks','hooks');" type="button" class="btn btn-outline-warning">Hooks</button>
      <button onclick="document.location='/architect/disk-cache'" type="button" class="btn btn-outline-warning">Cache</button>
      <button onclick="Cardify('Queries','queriesRun');" type="button" class="btn btn-outline-warning">Queries</button>
      <button onclick="Cardify('Databases','databases');" type="button" class="btn btn-outline-warning">Databases</button>
      <button onclick="Cardify('Users','users');" type="button" class="btn btn-outline-warning">Users</button>
      <button onclick="Cardify('Groups','groups');" type="button" class="btn btn-outline-warning">Groups</button>
      <button onclick="Cardify('New View','newView');" type="button" class="btn btn-info" >New View</button>
    </form>
  </div>
</div><br>
<div class="row">
  <div class="hidden" id="groups">
    <?php
      echo ArrTabler(Query("SELECT * FROM `Group`"));
    ?>
  </div>
  <div class="hidden" id="users">
    <?php
      echo ArrTabler(Query("
        SELECT * FROM `User`
      "));
    ?>
  </div>
  <div class="hidden" id="hooks">
    <?php pd($EVENTS); ?>
  </div>
  <div class="hidden" id="debugSummary">
    <?php DebugShowSummary(); ?>
  </div>
  <div class="hidden" id="queriesRun">
    <?php 
      pd(htmlentities($QUERIES_RUN));
    ?>
  </div>
  <div class="hidden" id="databases">
    <?php 
      global $ASTRIA;
      $temp=array();
      foreach($ASTRIA['databases'] as $name => $database){
        $temp[$name]=$database['resource'];
      }
      pd(htmlentities(var_export($temp,true)));
    ?>
  </div>
  <div class="hidden" id="newView">
    <form action="/architect/new-view" method="post">
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="View Name" name="newViewName" id="newViewName">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Description" name="newViewDescription" id="newViewDescription">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Slug" name="newViewSlug" id="newViewSlug">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success">Create View</button>
        </div>
      </div>
    </form>
  </div>
</div>
    
<div class="row">
  <div class="col-xs-12">
    <?php echo ArchitectShowViewCategoryTree(); ?>
  </div>
</div>
    
<?php
}
