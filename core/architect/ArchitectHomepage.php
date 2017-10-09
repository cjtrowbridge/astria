<?php

function ArchitectHomepage(){
  TemplateBootstrap4('Architect','ArchitectBodyCallback();'); 
}
  
function ArchitectBodyCallback(){
  global $EVENTS, $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $DEBUG, $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE,$ASTRIA;
  ?>
<h1>Architect 
  
  <span style="float: right;">
    <a href="https://github.com/cjtrowbridge/astria" target="_blank"><svg height="24" class="octicon octicon-mark-github" viewBox="0 0 16 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg></a>
    <a href="/architect/configuration" target="_blank" style="color: #000;"><i class="material-icons">settings</i></a>
  </span>
</h1>
<p>
  <b><?php echo file_get_contents('/etc/hostname'); ?></b>
  <i><?php echo shell_exec('uptime'); ?></i>
</p>

<div class="row">
  <div class="col-xs-12">
    <div class="form-inline">
      <h4>Architect Tools:</h4>
      <p>
        <a href="/architect/files" class="btn btn-outline-success"><i class="material-icons">folder</i> File Manager</a>
        <a href="/architect/plugins" class="btn btn-outline-success"><i class="material-icons">&#xE63C;</i> Plugins</a>
        <a href="/architect/schema" class="btn btn-outline-success"><i class="material-icons">&#xE322;</i> Schema</a>
        <?php Event('Architect Tools 1'); ?>
      </p>
      <p>
        <a href="/architect/events" class="btn btn-outline-success">Events</a>
        <a href="/architect/session" class="btn btn-outline-success">Session</a>
      </p>
      <p>
        <a href="/architect/user" class="btn btn-outline-success">User</a>
        <a href="/architect/usergroup" class="btn btn-outline-success">User Group</a>
        <a href="/architect/usergroupmembership" class="btn btn-outline-success">User Group Membership</a>
      </p>
      <p>
        <a href="/architect/df" class="btn btn-outline-warning">df</a>
        <a href="/architect/ifconfig" class="btn btn-outline-warning">ifconfig</a>
        <a href="/architect/top" class="btn btn-outline-warning">top</a>
      </p>
      <p>
        <a href="/architect/git-webhooks" class="btn btn-outline-danger">Git Webhooks</a>
      </p>
    </div>
  </div>
</div>


<?php CheckForUpdates(); ?>


<div class="row">
  <div class="col-xs-12">
    <?php
      //TODO maybe show the schemas?
      Event('Architect Homepage');
    ?>
  </div>
</div>

<?php
}
