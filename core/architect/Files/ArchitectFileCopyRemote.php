<?php

function ArchitectFileCopyRemote(){
  if(isset($_POST['url'])){
    
    $Source = $_POST['url'];
    $Destination = $_POST['destination'];
    
    if(is_dir($Destination)){
      $URL = parse_url($Source);
      if(!(isset($URL['path']))){
        die("<h1>Invalid url. Can't find a filename.</h1>");
      }
      $FilePath = $URL['path'];
      $LastSlashPosition = strrpos($FilePath,'/')+1;
      
      if($LastSlashPosition<=0){
        die("<h1>Invalid url. Can't find a filename.</h1>");
      }
      
      $Filename = substr($FilePath,$LastSlashPosition);
      
      $Destination.='/'.$Filename;
      $Destination=str_replace('//','/',$Destination);
    }
    if(file_exists($Destination)){
      die('<h1>File Already Exists.</h1>');
    }
    $Result = copy($Source,$Destination);
    if($Result){
      $Directory = basename(str_replace($_SERVER['DOCUMENT_ROOT'],'',$Desination));
      header('Location: /architect/files/?path=/'.$Directory);
      exit;
    }else{
      die('<h1>Error</h1>'); 
    }
  }
  TemplateBootstrap4('Copy Remote File - Architect','ArchitectFileCopyRemoteBodyCallback();'); 
}

function ArchitectFileCopyRemoteBodyCallback(){
  
  ?>
  
  <h1>Copy Remote File</h1>
  <form action="/architect/files/copy-remote/" method="post" class="form">
    <input type="text" class="form-control" name="url" id="url" placeholder="URL"><br>
    <input type="text" class="form-control" name="destination" id="destination" value="<?php echo $_SERVER['DOCUMENT_ROOT']; if(isset($_GET['path'])){echo $_GET['path'];} ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Create File">
  </form>
  
  <?php
}
