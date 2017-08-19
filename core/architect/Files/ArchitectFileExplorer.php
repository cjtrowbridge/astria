<?php

function ArchitectFileExplorer(){
  if(
    (!(isset($_GET['path'])))||
    ($_GET['path']=='')
  ){
    header('Location: /architect/files/?path=/');
    exit;
  }
  TemplateBootstrap4('File Explorer - Architect','ArchitectFileExplorerBodyCallback();'); 

}

function ArchitectFileExplorerBodyCallback(){
  //TODO check for escape attempts
  
  $LinkPaths = explode(DIRECTORY_SEPARATOR,$_GET['path']);
  pd($LinkPaths);
  $CompleteLinkPath = '';
  $Pwd = '';
  foreach($LinkPaths as $LinkPath){
    
    //If its blank, skip it
    if($LinkPath == ''){
      continue;
    }
    
    //Don't put slashes after files
    $Pwd .= $LinkPath;
    if(is_dir($Pwd)){
      $Pwd.= DIRECTORY_SEPARATOR;
    }
    
    $CompleteLinkPath .= '<a href="/architect/files/?path=/'.$Pwd.'">'.$LinkPath.'</a>';
    
  }
  
  echo '<h1><a href="/architect/files/?path=/">Astria</a>:'.$CompleteLinkPath.'</h1>'.PHP_EOL;
  
  if(is_dir($_SERVER['DOCUMENT_ROOT'].$_GET['path'])){
    ArchitectFileExplorerDirectory();
  }elseif(is_file($_SERVER['DOCUMENT_ROOT'].$_GET['path'])){
    ArchitectFileExplorerFile();
  }else{
    echo '<p>Invalid Path: '.$_SERVER['DOCUMENT_ROOT'].$_GET['path'].'</p>';
  }
  
}
          
function ArchitectFileExplorerFile(){
  ?>
  <p>
    <a href="<?php echo $_GET['path']; ?>" target="_blank" class="btn btn-primary">Launch This File</a>
    <a href="/architect/files/edit/?path=<?php echo $_GET['path']; ?>" class="btn btn-primary">Edit This File</a>
    <a href="/architect/files/delete/?path=<?php echo $_GET['path']; ?>" class="btn btn-danger">Delete This File</a>
  </p>
  
  <?php
  
  $path_parts = pathinfo($_SERVER['DOCUMENT_ROOT'].$_GET['path']);
  switch(strtolower($path_parts['extension'])){
    case 'php':
    case 'js':
    case 'css':
    case 'txt':
    case 'html':
    case 'htm':
    case 'shtm':
    case 'sql':
      echo '<div class="card"><div class="card-block"><div class="card-text"><pre><code>'.htmlentities(file_get_contents($_SERVER['DOCUMENT_ROOT'].$_GET['path'])).'</code></pre></div></div></div>';
      break;
    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
    case 'bmp':
    case 'ico':
      echo '<img src="'.$_GET['path'].'" style="max-width: 100%; max-height: 100%;>';
      break;
    default:
      echo 'No default preview method is set for this extension type.';
      break;
  }
}

function ArchitectFileExplorerDirectory(){
  $directories=array();
  $files=array();
  if(!(substr($_GET['path'], -1)=='/')){
    $_GET['path']=$_GET['path'].'/';
  }
  $path=$_SERVER['DOCUMENT_ROOT'].$_GET['path'];
  
  ?>
    <p>
      <a href="/architect/files/create-file/?path=<?php echo $_GET['path']; ?>" class="btn btn-sm btn-outline-success">Create File</a>
      <a href="/architect/files/create-directory/?path=<?php echo $_GET['path']; ?>" class="btn btn-sm btn-outline-success">Create Directory</a>
      <a href="/architect/files/upload/?path=<?php echo $_GET['path']; ?>" class="btn btn-sm btn-outline-warning">Upload File</a>
      <a href="/architect/files/delete-directory/?path=<?php echo $_GET['path']; ?>" class="btn btn-sm btn-outline-danger">Delete Directory</a>
    </p>
  <?php
  
  if($handle = opendir($path)){
    while(false !== ($entry = readdir($handle))){
      if(is_dir($path.DIRECTORY_SEPARATOR.$entry)){
        if(($entry !== '.')&& ($entry!=='..')){
          $directories[$entry]=$path.DIRECTORY_SEPARATOR.$entry;
        }
      }else{
        $files[$entry]=$path.DIRECTORY_SEPARATOR.$entry;
      }
    }
    closedir($handle);
  }
  asort($directories);
  asort($files);
  
  
  if(!($_GET['path']=='/')){
    $Parent=realpath($_GET['path'].'..');
    echo '<p><a href="/architect/files/?path='.$Parent.'"><img src="/icons/folder.gif" alt="[DIR]"> ..</a><p>'.PHP_EOL;  
  }
  foreach($directories as $name => $directory){
    echo '<p><a href="/architect/files/?path='.$_GET['path'].$name.'"><img src="/icons/folder.gif" alt="[DIR]"> '.$name.'</a><p>'.PHP_EOL;
  }
  foreach($files as $name => $file){
    echo '<p><a href="/architect/files/?path='.$_GET['path'].$name.'"><img src="/icons/unknown.gif" alt="[DIR]"> '.$name.'</a><p>'.PHP_EOL;
  }
}
