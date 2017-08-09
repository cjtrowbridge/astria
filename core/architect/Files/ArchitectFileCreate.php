<?php

function ArchitectFileCreate(){
  TemplateBootstrap4('File Editor - Architect','ArchitectFileCreateBodyCallback();'); 
}
function ArchitectFileCreateBodyCallback(){
  ?>
  
  <h1>Create File</h1>
  <form action="/architect/files/edit/" method="get" class="form">
    <input type="text" class="form-control" name="path" value="<?php echo $_GET['path']; ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Create File">
  </form>
  
  <?php
}
