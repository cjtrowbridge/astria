<?php

function ArchitectFileCopyRemote(){
  TemplateBootstrap4('Copy Remote File - Architect','ArchitectFileCopyRemoteBodyCallback();'); 
}

function ArchitectFileCopyRemoteBodyCallback(){
  if(isset($_POST['url'])){
  
    return;
  }
  ?>
  
  <h1>Copy Remote File</h1>
  <form action="/architect/files/copy-remote/" method="get" class="form">
    <input type="text" class="form-control" name="url" id="url" placeholder="URL"><br>
    <input type="text" class="form-control" name="url" id="url" value="<?php echo $_SERVER['DOCUMENT_ROOT'].$_GET['path'] ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Create File">
  </form>
  
  <?php
}
