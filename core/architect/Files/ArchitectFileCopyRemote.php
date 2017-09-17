<?php

function ArchitectFileCopyRemote(){
  TemplateBootstrap4('Copy Remote File - Architect','ArchitectFileCopyRemoteBodyCallback();'); 
}

function ArchitectFileCopyRemoteBodyCallback(){
  if(isset($_POST['url'])){
    
    $Source = $_POST['url'];
    $Destination = $_POST['destination'];
    
    if(is_dir($Destination)){
      $URL = parse_url($Source);
      if(!(isset($URL['path']))){
        die("Invalid url. Can't find a filename.");
      }
      $FilePath = $URL['path'];
      $LastSlashPosition = strrpos($FilePath,'/')+1;
      
      if($LastSlashPosition>=0){
        die("Invalid url. Can't find a filename.");
      }
      
      $Filename = substr($FilePath,$LastSlashPosition);
      
      pd($Filename);
    }
    
    //copy($Source,$Destination);
    return;
    
  }
  ?>
  
  <h1>Copy Remote File</h1>
  <form action="/architect/files/copy-remote/" method="post" class="form">
    <input type="text" class="form-control" name="url" id="url" placeholder="URL"><br>
    <input type="text" class="form-control" name="destination" id="destination" value="<?php echo $_SERVER['DOCUMENT_ROOT'].$_GET['path'] ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Create File">
  </form>
  
  <?php
}
