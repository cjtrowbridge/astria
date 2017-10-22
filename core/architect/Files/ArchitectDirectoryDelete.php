<?php

function ArchitectDirectoryDelete(){
  if(isset($_GET['yesimsure'])){
    $Parent=realpath($_GET['path'].'..');
    if(rmdir($_SERVER['DOCUMENT_ROOT'].$_GET['path'])==false){
      die('<p>Unable to delete: '.$_GET['path'].'</p>');
    }
    header('Location: /architect/files/?path='.$Parent);
    exit;
  }
  TemplateBootstrap4('Directory Delete - Architect','ArchitectDirectoryDeleteBodyCallback();'); 
}
function ArchitectDirectoryDeleteBodyCallback(){
  ?>
  
  <h1>Delete Directory</h1>
  <h2>Are you sure you want to delete: <?php echo $_GET['path']; ?></h2><br>
  
  <div class="row">
    <div class="col-xs-12 col-md-6">
      <a href="/architect/files/delete-directory/?path=<?php echo $_GET['path']; ?>&yesimsure" class="btn btn-block btn-success">Yes</a>
    </div>
    <div class="col-xs-12 col-md-6">
      <a href="/architect/files/?path=<?php echo $_GET['path']; ?>" class="btn btn-block btn-danger">No</a>
    </div>
  </div>
  
  <?php
}
