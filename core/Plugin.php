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
  Event('Plugin Manager: Starting...');
  
  //Load plugin config file if it exists 
  if(file_exists('plugin.php')){include_once('plugin.php');}
  
  
  VerifyPluginListExists();
  
  //check if there are any new plugins present
  
  LookForNewPlugins();
  
  PluginLocalTest();
  
  //if(isset($_GET['testPlugins'])){
    TestPlugins();
    //header('Location: /architect');
    //exit;
  //}
  
  SortPluginsByPriority();
  
  IncludeGoodPlugins();

  Event('Plugin Manager: ...Finished');
}

function SortPluginsByPriority(){
  
}


function LookForNewPlugins(){
  global $ASTRIA;
  if(!(isset($ASTRIA['plugin']))){
    die("Can't load plugins file.");
  }
  
  $Plugins = getPluginDirList();
  
  foreach($Plugins as $Plugin){
    if(!(isset($ASTRIA['plugin'][$Plugin]))){
      $ASTRIA['plugin'][$Plugin]=array('state' => 'test','name' => $Plugin,'data'=>array());
    }
  }
  SavePluginConfig();
   
}



Hook('Before Login','PluginTestReset();');

function PluginTestReset(){
  require_once('core/IsAstriaAdmin.php');
  Event('Begin Plugin Test Handlers');
  
  if(isset($_GET['overrideTest'])){
    if(IsAstriaAdmin()){
      global $ASTRIA;
      if(
        isset($ASTRIA['plugin'][$_GET['overrideTest']])&&
        $ASTRIA['plugin'][$_GET['overrideTest']]['state']=='broken'
      ){
        $ASTRIA['plugin'][$_GET['overrideTest']]['state']='ready';
        SavePluginConfig();
        header('Location: /architect');
        sleep(1);
        exit;
      }else{
        die('This plugin is not broken. Unable to override test.');
      }
    }
  }
  if(isset($_GET['resetTest'])){
    if(IsAstriaAdmin()){
      global $ASTRIA;
      if(
        isset($ASTRIA['plugin'][$_GET['resetTest']])&&
        $ASTRIA['plugin'][$_GET['resetTest']]['state']=='broken'
      ){
        $ASTRIA['plugin'][$_GET['resetTest']]['state']='test';
        SavePluginConfig();
        
        PluginLocalTest($_GET['resetTest']);
        
        header('Location: /architect');
        sleep(1);
        exit;
      }else{
        die('This plugin is not broken. Unable to reset test.');
      }
    }
  }
  if(isset($_GET['enablePlugin'])){
    if(IsAstriaAdmin()){
      global $ASTRIA;
      if(
        isset($ASTRIA['plugin'][$_GET['enablePlugin']])&&
        $ASTRIA['plugin'][$_GET['enablePlugin']]['state']=='ready'
      ){
        $ASTRIA['plugin'][$_GET['enablePlugin']]['state']='enabled';
        SavePluginConfig();
        header('Location: /architect');
        sleep(1);
        exit;
      }else{
        die('This plugin is not Ready. Unable to enable.');
      }
    }
  }
  if(isset($_GET['disablePlugin'])){
    if(IsAstriaAdmin()){
      global $ASTRIA;
      if(
        isset($ASTRIA['plugin'][$_GET['disablePlugin']])&&
        $ASTRIA['plugin'][$_GET['disablePlugin']]['state']=='enabled'
      ){
        $ASTRIA['plugin'][$_GET['disablePlugin']]['state']='disable';
        SavePluginConfig();
        header('Location: /architect');
        sleep(1);
        exit;
      }else{
        die('This plugin is not enabled. Unable to disable.');
      }
    }
  }
  
  Event('End Plugin Test Handlers');
}



function TestPlugins(){
  Event('Testing Plugins...');
  
  global $ASTRIA;
  
  if(!(isset($ASTRIA['plugin']))){
    die('Unable to load plugin configuration.');
  }
  
  //Let's request a test for any plugins set to test or broken
  $Changes = 0;
  foreach($ASTRIA['plugin'] as $Path => $Plugin){
    if(
      $Plugin['state']=='test'
    ){
      $TestPath = $ASTRIA['app']['appURL'].'?testPlugin='.$Path;
      Event('Requesting Integration Test For Plugin: '.$Path.' ('.$TestPath.')');
      
      
      //This might not work, so dont throw an error if it doesn't.
      $PreviousErrorState = error_reporting();
      error_reporting(0);
      $Result = file_get_contents($TestPath);
      if($Result==false){
        
        //If we cant access the site publically, we will need to run a synchronous integration test. This is super not ideal, but sometimes necessary.
        $Result = PluginIntegrationTest($PluginPath);
        if($Result == true){
          $Result = 'ok';
        }else{
          $Result = '';
        }
        
      }
      error_reporting($PreviousErrorState);
      
      
      if(trim($Result)=='ok'){
        $Changes++;
        $ASTRIA['plugin'][$Path]['state'] = 'ready';
        Event('...Passed.');
      }else{
        $Changes++;
        $ASTRIA['plugin'][$Path]['state'] = 'broken';
        $ASTRIA['plugin'][$Path]['integrationTestError'] = $Result;
        Event('...Failed: '.$Result);
      }
      
    }
  }
  if($Changes>0){
    Event('Saving Changes...');
    SavePluginConfig();
    Event('Changes Saved.');
  }
  Event('Done Testing Plugins');
}

function PluginLocalTest($Index = false){
  if(!(isset($_GET['testPlugin']))){
    if($Index==false){
      return;
    }else{
     $_GET['testPlugin'] = $Index; 
    }
  }
  
  if(!(PluginIntegrationTest($_GET['testPlugin']) == false)){
    die('ok');
  }else{
    die();
  }
}

function PluginIntegrationTest($PluginPath){
  Event('Begin Plugin Integration Test: '.$PluginPath);
  $Found = false;
  global $ASTRIA;
  foreach($ASTRIA['plugin'] as $Index => $Plugin){
    if(
      (strtolower($_GET['testPlugin'])==strtolower($Index))&&
      ($Plugin['state']=='test' || $Plugin['state']=='broken') //Don't test plugins which are not set to test or broken
    ){
      $Found = $Index; 
      break;
    }
  }
  if(!($Found == false)){
    Loader('plugins/'.$Found);
    Event('End Plugin Integration Test: '.$PluginPath);
    return true;
  }else{
    Event('End Plugin Integration Test: '.$PluginPath);
    return false;
  }
}

function IncludeGoodPlugins(){
  global $ASTRIA;
  foreach($ASTRIA['plugin'] as $Dir => $Plugin){
    if($Plugin['state']=='enabled'){
      if(file_exists('plugins/'.$Dir)){
        Loader('plugins/'.$Dir);
      }else{
        $OldData = '/* '.var_export($ASTRIA['plugin'][$Dir],true).' */';
        file_put_contents('plugin.php', $OldData, FILE_APPEND | LOCK_EX);
        unset($ASTRIA['plugin'][$Dir]);
        SavePluginConfig();
      }
    }
  }
}

function VerifyPluginListExists(){
  
  global $ASTRIA;
  if(!(file_exists('plugin.php'))){
    //Need to create a plugins file
    copy('core/sample/plugin.sample.php','plugin.php');
    include('plugin.php');
    header("Location: ./");
    exit;
  }
  if(!(isset($ASTRIA['plugin']))){
    die('Unable to load plugin config file. Attempt to create a new file failed.');
  }
}

function SavePluginConfig(){
  global $ASTRIA;
  $newPluginsFile="<?php ".PHP_EOL."global \$ASTRIA;".PHP_EOL."\$ASTRIA['plugin'] = array(";
  foreach($ASTRIA['plugin'] as $Index => $Plugin){
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


