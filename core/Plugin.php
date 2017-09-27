<?php

/*

Plugin States

test    - needs to be tested
ready   - has been tested but needs to be activated
enabled - is enabled and should be included in every page load
broken  - failed an integration test


TODO make the plugins retain previous versions and revert when changes cause broken

*/

function LoadPlugins(){
  //Load plugin config file if it exists 
  if(file_exists('plugin.php')){include_once('plugin.php');}
  
  VerifyPluginListExists();
  
  TestPlugins();
  
  SortPluginsByPriority();
  
  IncludeGoodPlugins();

}

function SortPluginsByPriority(){
  
}

function TestPlugins(){
  global $ASTRIA;
  
  if(isset($_GET['testPlugin'])){
    PluginLocalTest();
  }
  
  //Let's test any plugins set to test or broken
  $Changes = 0;
  foreach($ASTRIA['plugin'] as $Path => $Plugin){
    if(
      $Plugin['state']=='test'
    ){
      
      $Result = file_get_contents($ASTRIA['app']['appURL']);
      
      if($Result=='ok'){
        $Changes++;
        $ASTRIA['plugin'][$Path]['state'] = 'ready';
      }else{
        $Changes++;
        $ASTRIA['plugin'][$Path]['state'] = 'broken';
      }
      
    }
  }
  if($Changes>0){
    SavePluginConfig();
  }
  
}

function PluginLocalTest(){
  $Found = false;
  global $ASTRIA;
  foreach($ASTRIA['plugin'] as $Index => $Plugin){
    if(
      (strtolower($_GET['testPlugin'])==strtolower($Index))&&
      ($Plugin['state']=='test' || $Plugin['state']=='broken') //Don't test plugins which are not set to test or broken
    ){
     $Found = $Index; 
    }
  }
  if(!($Found == false)){
    Loader('plugins/'.$Found);
    die('ok');
  }else{
    die();
  }
}

function IncludeGoodPlugins(){
  global $ASTRIA;
  //foreach($ASTRIA['plugin'] as $Dir => $Plugin){
    //if(){
      //$ASTRIA['plugin']
    //}
  //}
}

function VerifyPluginListExists(){
  
  global $ASTRIA;
  if(!(isset($ASTRIA['plugin']))){
    if(!(file_exists('plugin.php'))){
      //Need to create a plugins file
      $Plugins = getPluginDirList();
      foreach($Plugins as $Plugin){
        $ASTRIA['plugin'][$Plugin]=array();
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
    $newPluginsFile.=PHP_EOL.PHP_EOL.
      "  '$Index' => array(".PHP_EOL.
      "    'state' => '".$Plugin['state']."',".PHP_EOL.
      "    'name' => '".$Plugin['name']."',".PHP_EOL.
      "    'data' => ".var_export($Plugin['data'],true).PHP_EOL.
      "  ),".PHP_EOL.PHP_EOL;
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
