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
  //Note: If you have access to this tool as a user, you have complete control of the filesystem. Preventing escape attempts from the root directory of the application seems like a moot point, but it might make sense to add this later.
  
  $LinkPaths = explode(DIRECTORY_SEPARATOR,$_GET['path']);
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
    
    //put non-link slashes in for between directories
    if(is_dir($Pwd)){
      $CompleteLinkPath.= DIRECTORY_SEPARATOR;
    }
    
  }
  
  echo '<h1>Path: <a href="/architect/files/?path=/">Astria</a>/'.$CompleteLinkPath.'</h1>'.PHP_EOL;
  
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
  $LocalPath = $_SERVER['DOCUMENT_ROOT'].$_GET['path'];
  switch(strtolower($path_parts['extension'])){
    case 'mp4':
    case 'mkv':
    case 'avi':
    case 'mov':
    case 'flv':
    case 'mpeg':
    case 'wmv':
      //TODO make some way of opening a relative path
      echo '<div class="card"><div class="card-block"><div class="card-text"><video controls preload style="width: 100%; max-width: 100%;"><source src="'.$_GET['path'].'"></video></div></div></div>';
      break;
    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
    case 'bmp':
    case 'ico':
      echo '<img src="'.$_GET['path'].'" style="width: 100%; max-width: 100%; max-height: 100%;>';
      break;
    case 'htaccess':
    case 'php':
    case 'js':
    case 'css':
    case 'txt':
    case 'html':
    case 'htm':
    case 'shtm':
    case 'sql':
    case 'txt':
    case 'json':
    case 'xml':
    default:
      $Text = file_get_contents($_SERVER['DOCUMENT_ROOT'].$_GET['path']);
      echo '<div class="card"><div class="card-block"><div class="card-text"><pre><code>'.htmlentities(substr($Text,0, (100*1024) ));
      if(strlen($Text)>1000){
        echo '...';
      }
      echo '</code></pre></div></div></div>';
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
      <a href="/architect/files/copy-remote/?path=<?php echo $_GET['path']; ?>" class="btn btn-sm btn-outline-warning">Copy a Remote File</a>
      <a href="/architect/files/delete-directory/?path=<?php echo $_GET['path']; ?>" class="btn btn-sm btn-outline-danger">Delete Directory</a>
    </p>
  <?php
  
  if($handle = opendir($path)){
    while(false !== ($entry = readdir($handle))){
      if(is_dir($path.DIRECTORY_SEPARATOR.$entry)){
        if(($entry !== '.') /*&& ($entry!=='..')*/){
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
  
  $Dir = array();
  
  foreach($directories as $name => $directory){
    //echo '<p><a href="/architect/files/?path='.$_GET['path'].$name.'"><img src="/icons/folder.gif" alt="[DIR]"> '.$name.'</a><p>'.PHP_EOL;
    $Dir[]=array(
      'Filename' => '<img src="/icons/folder.gif" alt="[DIR]"> <a href="/architect/files/?path='.$_GET['path'].$name.'">'.$name.'</a>',
      //'Created' =>  '<span title="'.date('Y-m-d H:i:s',filectime($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)).'">'.ago(filectime($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)).'</span>',
      'Modified' => '<span title="'.date('Y-m-d H:i:s',filemtime($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)).'">'.ago(filectime($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)).'</span>',
      'Size' => hFileSize($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)
    );
  }
  foreach($files as $name => $file){
    //echo '<p><a href="/architect/files/?path='.$_GET['path'].$name.'"><img src="/icons/unknown.gif" alt="[DIR]"> '.$name.'</a><p>'.PHP_EOL;
    $Dir[]=array(
      'Filename' => '<img src="/icons/unknown.gif" alt="[FILE]"> <a href="/architect/files/?path='.$_GET['path'].$name.'">'.$name.'</a>',
      //'Created' =>  '<span title="'.date('Y-m-d H:i:s',filectime($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)).'">'.ago(filectime($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)).'</span>',
      'Modified' => '<span title="'.date('Y-m-d H:i:s',filemtime($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)).'">'.ago(filectime($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)).'</span>',
      'Size' => hFileSize($_SERVER['DOCUMENT_ROOT'].$_GET['path'].$name)
    );
  }
  echo ArrTabler($Dir);
  
}
