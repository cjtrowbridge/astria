<?php

Hook('User Is Logged In','MaybeCheckForUpdates();');

function MaybeCheckForUpdates(){
  if(
    isset($_GET['checkForUpdates'])&&
    HasMembership('Astria Administrators')
  ){
    CheckNowForUpdates();
    exit;
  }
}

function CheckForUpdates(){
  ?>

<div class="card">
  <div class="card-block">
    <div class="card-text" id="updatesChecker">
      <p><center><img src="/img/spinner.gif"><br>Checking For Updates...</center></p>
    </div>
  </div>
</div>

<script>
  $.get("/?checkForUpdates",function(data){
    $('#updatesChecker').html(data);
  });
</script>

  <?php
}

function CheckNowForUpdates(){
  Event("Begining Checking For Updates");
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
  Event("Done Checking For Updates");
}
