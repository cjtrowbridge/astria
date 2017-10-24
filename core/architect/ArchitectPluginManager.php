<?php

function ArchitectPluginManager(){

  TemplateBootstrap4('Plugin Manager','ArchitectPluginManagerBodyCallback();');
}

function ArchitectPluginManagerBodyCallback(){
  global $ASTRIA;
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/plugins">Plugins</a></h1>

<?php
  
  ksort($ASTRIA['plugin']);
  
  foreach($ASTRIA['plugin'] as $Index => $Plugin){
  
  ?>

<div class="card">
  <div class="card-block">
    <h4 class="card-title"><a href="/architect/files/?path=/plugins/<?php echo $Index; ?>/"><?php echo $Plugin['name']; ?></a></h4>
    <div class="card-text">
      <p><b>State:</b> <?php 
    
      switch($Plugin['state']){
        case 'test':
          echo 'Integration test is pending...';
          break;
        case 'ready':
          echo '<b style="color: green;">Passed Integration Test, Ready.</b> (<a href="/?enablePlugin='.$Index.'">Activate Plugin</a>)';
          break;
        case 'enabled':
          echo 'Enabled, Running Normally. (<a href="/?disablePlugin='.$Index.'">Disable</a>)';
          break;
        case 'broken':
          echo '<b style="color: red;">Integration Test Failed</b> (<a href="/?resetTest='.$Index.'">Test Again</a>) or (<a href="/?overrideTest='.$Index.'">Override Test</a>)';
          break;
      }
    
      ?></p>
      <?php
        $Command = 'grep -o -r "TODO" '.$_SERVER["DOCUMENT_ROOT"].'/plugins/'.$Index.' | wc -l';
        $Todos = shell_exec($Command);
      if($Todos>0){
        ?>
        <p>Number of TODOs: <?php echo $Todos; ?></p>
        <?php
      }
      ?>
    </div>
  </div>
</div>

    <?php
  }
}
