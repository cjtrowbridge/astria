<?php

function ArchitectFileDelete(){
  TemplateBootstrap4('File Delete - Architect','ArchitectFileDeleteBodyCallback();'); 
}
function ArchitectFileDeleteBodyCallback(){
  ?>
  
  <h1>Delete File</h1>
  <h2>Are you sure you want to delete: <?php echo $_GET['path']; ?></h2>
  
  <div class="row">
    <div class="col-xs-12 col-md-6">
      <a href="/architect/files/delete/?path=<?php echo $_GET['path']; ?>&yesimsure" class="btn btn-block btn-success">Yes</a>
    </div>
    <div class="col-xs-12 col-md-6">
      <a href="/architect/files/?path=<?php echo $_GET['path']; ?>" class="btn btn-block btn-danger">No</a>
    </div>
  </div>
  
  <?php
}
