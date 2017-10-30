<?php

function ArchitectFileSearch(){
  if(isset($_POST['query'])){
    die('k');
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
      header('Location: /architect/files/?path='.$_POST['redirect']);
      exit;
    }else{
      die('<h1>Error</h1>'); 
    }
  }
  TemplateBootstrap4('File Search - Architect','ArchitectFileCopyRemoteBodyCallback();'); 
}
function ArchitectFileCopyRemoteBodyCallback(){
  ?>
  
  <h1>File Search</h1>
  <form action="/architect/search/" method="get" class="form">
    <input type="text" class="form-control" name="path" id="pat" value="<?php echo $_SERVER['DOCUMENT_ROOT']; if(isset($_GET['path'])){echo $_GET['path'];} ?>"><br>
    <input type="text" class="form-control" name="query" id="query" placeholder="Query"><br>
    <input type="submit" class="btn btn-block btn-success" value="File Search">
  </form>
  
  <?php
}
