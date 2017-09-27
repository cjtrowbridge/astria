<?php

function LoadPlugins(){
  global $ASTRIA;
  if(!(isset($ASTRIA['plugin']))){
    if(file_exists('plugin.php')){
      include_once('plugin.php');
    }else{
      //Need to create a plugins file
      $newPluginsFile="<?php ".PHP_EOL."global \$ASTRIA;".PHP_EOL."\$ASTRIA['plugin'] = array(";
      $Plugins = getPluginDirList();
      foreach($Plugins as $Plugin){
        $newPluginsFile.=PHP_EOL."  '$Plugin' => array('state' => 'test'),";
      }
      $newPluginsFile=rtrim($newPluginsFile,',');
      $newPluginsFile.=PHP_EOL.");";
      
      $result=file_put_contents('plugin.php', $newPluginsFile);
      if($result==false){
       die("Could not write plugin config file. Please give write permission or copy the following into a new plugin.php file;\n\n".$newPluginsFile); 
      }
      
      
      
    }
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
