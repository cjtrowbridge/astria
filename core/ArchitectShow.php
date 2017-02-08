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
    <?php
      echo '<p>Current User: ID '.$ASTRIA['Session']['User']['UserID'].', Email '.$ASTRIA['Session']['User']['Email'].'.';
      echo ' Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4)." seconds.";
      echo ' Ran '.$NUMBER_OF_QUERIES_RUN.' Database Queries.';
      echo ' Ran '.$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE.' Queries From Disk Cache.';
      echo ' Session Expires '.date('r',$ASTRIA['Session']['Auth']['Expires']).'.</p>';
    ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <form class="form-inline">
      <button onclick="document.location='/architect/schema'" type="button" class="btn btn-outline-warning">Schema</button>
      <button onclick="Cardify('Events','debugSummary');" type="button" class="btn btn-outline-warning">Events</button>
      <button onclick="Cardify('Hooks','hooks');" type="button" class="btn btn-outline-warning">Hooks</button>
      <button onclick="document.location='/architect/disk-cache'" type="button" class="btn btn-outline-warning">Cache</button>
      <button onclick="Cardify('Queries','queriesRun');" type="button" class="btn btn-outline-warning">Queries</button>
      <button onclick="Cardify('Session','session');" type="button" class="btn btn-outline-warning">Session</button>
      <button onclick="Cardify('Databases','databases');" type="button" class="btn btn-outline-warning">Databases</button>
      <button onclick="Cardify('Users','users');" type="button" class="btn btn-outline-warning">Users</button>
      <button onclick="Cardify('Views','views');" type="button" class="btn btn-outline-warning">Views</button>
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
  <div class="hidden" id="views">
    <?php
      echo ArrTabler(Query("
        SELECT * FROM `View`
      "));
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
  <div class="hidden" id="session">
    <?php 
      $temp=$ASTRIA['Session'];
      unset($temp['google_oauth2']);
      pd(htmlentities(var_export($temp,true)));
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
    
    
    
    
<link rel="stylesheet" href="/css/treeview.css">
<div class="css-treeview">
    <ul>
        <li><input type="checkbox" id="item-0" /><label for="item-0">This Folder is Closed By Default</label>
            <ul>
                <li><input type="checkbox" id="item-0-0" /><label for="item-0-0">Ooops! A Nested Folder</label>
                    <ul>
                        <li><input type="checkbox" id="item-0-0-0" /><label for="item-0-0-0">Look Ma - No Hands!</label>
                            <ul>
                                <li><a href="./">First Nested Item</a></li>
                                <li><a href="./">Second Nested Item</a></li>
                                <li><a href="./">Third Nested Item</a></li>
                                <li><a href="./">Fourth Nested Item</a></li>
                            </ul>
                        </li>
                        <li><a href="./">Item 1</a></li>
                        <li><a href="./">Item 2</a></li>
                        <li><a href="./">Item 3</a></li>
                    </ul>
                </li>
                <li><input type="checkbox" id="item-0-1" /><label for="item-0-1">Yet Another One</label>
                    <ul>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                    </ul>
                </li>
                <li><input type="checkbox" id="item-0-2" disabled="disabled" /><label for="item-0-2">Disabled Nested Items</label>
                    <ul>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                    </ul>
                </li>
                <li><a href="./">item</a></li>
                <li><a href="./">item</a></li>
                <li><a href="./">item</a></li>
                <li><a href="./">item</a></li>
        </ul>
</li>
<li><input type="checkbox" id="item-1" checked="checked" /><label for="item-1">This One is Open by Default...</label>
        <ul>
            <li><input type="checkbox" id="item-1-0" /><label for="item-1-0">And Contains More Nested Items...</label>
                <ul>
                    <li><a href="./">Look Ma - No Hands</a></li>
                    <li><a href="./">Another Item</a></li>
                    <li><a href="./">And Yet Another</a></li>
                </ul>
            </li>
            <li><a href="./">Lorem</a></li>
            <li><a href="./">Ipsum</a></li>
            <li><a href="./">Dolor</a></li>
            <li><a href="./">Sit Amet</a></li>
        </ul>
</li>
<li><input type="checkbox" id="item-2" /><label for="item-2">Can You Believe...</label>
        <ul>
                <li><input type="checkbox" id="item-2-0" /><label for="item-2-0">That This Treeview...</label>
                    <ul>
                        <li><input type="checkbox" id="item-2-2-0" /><label for="item-2-2-0">Does Not Use Any JavaScript...</label>
                            <ul>
                                <li><a href="./">But Relies Only</a></li>
                                <li><a href="./">On the Power</a></li>
                                <li><a href="./">Of CSS3</a></li>
                            </ul>
                        </li>
                        <li><a href="./">Item 1</a></li>
                        <li><a href="./">Item 2</a></li>
                        <li><a href="./">Item 3</a></li>
                    </ul>
                </li>
                <li><input type="checkbox" id="item-2-1" /><label for="item-2-1">This is a Folder With...</label>
                    <ul>
                        <li><a href="./">Some Nested Items...</a></li>
                        <li><a href="./">Some Nested Items...</a></li>
                        <li><a href="./">Some Nested Items...</a></li>
                        <li><a href="./">Some Nested Items...</a></li>
                        <li><a href="./">Some Nested Items...</a></li>
                    </ul>
                </li>
                <li><input type="checkbox" id="item-2-2" disabled="disabled" /><label for="item-2-2">Disabled Nested Items</label>
                    <ul>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                        <li><a href="./">item</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>
    
  </div>
</div>
    
<?php
}
