<?php

function CheckForUpdates(){
  global $ASTRIA;
  $Local  = gitLocalHash();
  $Global = gitGlobalHash();

  if(!($Local==$Global)){
    ?>
      <div class="row">
        <div class="col-xs-12">
          <h2>Updates are Available!</h2>
          <a href="<?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?>">Pull Mainline From Github, pending an integration test.</a>
          <p>Local Master Head is at: <?php echo $Local; ?></p>
          <p>Global Master Head is at: <?php echo $Global; ?></p>
        </div>
      </div>
    <?php
  }
}
