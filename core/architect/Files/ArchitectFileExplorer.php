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
  
  echo '<h1><a href="/architect/files/?path=/">Astria</a>:'.$_GET['path'].'</h1>'.PHP_EOL;
  
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
  <p><a href="<?php echo $_GET['path']; ?>" target="_blank">Launch This File</a></p>
  <p><a href="/architect/files/edit/?path=<?php echo $_GET['path']; ?>">Edit This File</a></p>
  <p><a href="/architect/files/delete/?path=<?php echo $_GET['path']; ?>">Delete This File</a></p>
  
  <?php
}

function ArchitectFileExplorerDirectory(){
  $directories=array();
  $files=array();
  if(!(substr($_GET['path'], -1)=='/')){
    $_GET['path']=$_GET['path'].'/';
  }
  $path=$_SERVER['DOCUMENT_ROOT'].$_GET['path'];
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
  
  
  
  $Parent=realpath($_GET['path'].'..');
  echo '<p><a href="/architect/files/?path='.$Parent.'"><img src="/icons/folder.gif" alt="[DIR]"> ..</a><p>'.PHP_EOL;  
  
  foreach($directories as $name => $directory){
    echo '<p><a href="/architect/files/?path='.$_GET['path'].$name.'"><img src="/icons/folder.gif" alt="[DIR]"> '.$name.'</a><p>'.PHP_EOL;
  }
  foreach($files as $name => $file){
    echo '<p><a href="/architect/files/?path='.$_GET['path'].$name.'"><img src="/icons/unknown.gif" alt="[DIR]"> '.$name.'</a><p>'.PHP_EOL;
  }
}
