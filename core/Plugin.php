<?php

function LoadPlugins(){
  VerifyPluginListExists();
  TestPlugins();
  IncludeGoodPlugins();
}

function TestPlugins(){
  if(isset($_GET['testPlugin'])){
    
  }
}

function IncludeGoodPlugins(){
  
}

function VerifyPluginListExists(){
  global $ASTRIA;
  if(!(isset($ASTRIA['plugin']))){
    if(file_exists('plugin.php')){
      include_once('plugin.php');
    }else{
      //Need to create a plugins file
      $Plugins = getPluginDirList();
      foreach($Plugins as $Plugin){
        $ASTRIA['plugins'][$Plugin]=array();
      }
      SavePluginConfig();
    }
  }
}

function SavePluginConfig(){
  global $ASTRIA;
  $newPluginsFile="<?php ".PHP_EOL."global \$ASTRIA;".PHP_EOL."\$ASTRIA['plugin'] = array(";
  foreach($ASTRIA['plugins'] as $Index => $Plugin){
    if(!(isset($Plugin['name']))){
      $Plugin['name']=$Index;
    }
    if(!(isset($Plugin['state']))){
      $Plugin['state']='test';
    }
    if(!(isset($Plugin['data']))){
      $Plugin['data']=array();
    }
    $newPluginsFile.=PHP_EOL.
      "  '$Plugin' => array(".PHP_EOL.
      "    'state' => '".$Plugin['state']."',".PHP_EOL.
      "    'name' => '".$Plugin['name']."',".PHP_EOL.
      "    'data' => ".var_export($Plugin['data']).PHP_EOL.
      "  ),";
  }
  $newPluginsFile=rtrim($newPluginsFile,',');
  $newPluginsFile.=PHP_EOL.");";

  $result=file_put_contents('plugin.php', $newPluginsFile);
  if($result==false){
   die("Could not write plugin config file. Please give write permission or copy the following into a new plugin.php file;\n\n".$newPluginsFile); 
  } 
}

function getPluginDirList(){
  $dirs = array();
  if($handle = opendir('plugins')){
    while (false !== ($dir = readdir($handle))){
      if($dir != "." && $dir != ".." && is_dir('plugins/'.$dir)){
        $dirs[]=$dir;
      }
    }
    closedir($handle);
    return $dirs;
  }else{
    die('Unable to load plugins directory.');
  }
}
