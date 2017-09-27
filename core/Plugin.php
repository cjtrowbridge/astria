<?php

/*

Plugin States

test    - needs to be tested
ready   - has been tested but needs to be activated
enabled - is enabled and should be included in every page load
broken  - failed an integration test


TODO make the plugins retain previous versions and revert when changes cause broken

*/

require_once('core/IsAstriaAdmin.php');

if(IsAstriaAdmin()){
  if(isset($_GET['resetTest'])){
    global $ASTRIA;
    if(
      isset($ASTRIA['plugin'][$_GET['resetTest']])&&
      $ASTRIA['plugin'][$_GET['resetTest']]['state']=='broken'
    ){
      $ASTRIA['plugin'][$_GET['resetTest']]['state']='test';
      SavePluginConfig();
      header('Location: /architect');
      exit;
    }
  }
}

Hook('Architect Homepage','PluginsArchitectHomepage();');

function LoadPlugins(){
  Event('Plugin Manager: Starting...');
  
  //Load plugin config file if it exists 
  if(file_exists('plugin.php')){include_once('plugin.php');}
  
  VerifyPluginListExists();
  PluginLocalTest();
  
  //if(isset($_GET['testPlugins'])){
    Event('Testing Plugins...');
    TestPlugins();
    Event('Done Testing Plugins');
    //header('Location: /architect');
    //exit;
  //}
  
  SortPluginsByPriority();
  
  IncludeGoodPlugins();

  Event('Plugin Manager: ...Finished');
}

function SortPluginsByPriority(){
  
}

function TestPlugins(){
  global $ASTRIA;
  
  //Let's request a test for any plugins set to test or broken
  $Changes = 0;
  foreach($ASTRIA['plugin'] as $Path => $Plugin){
    if(
      $Plugin['state']=='test'
    ){
      Event('Requesting Integration Test For Plugin: '.$Path);
      $TestPath = $ASTRIA['app']['appURL'].'?testPlugin='.$Path;
      
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
}

function PluginLocalTest(){
  if(!(isset($_GET['testPlugin']))){
    return;
  }
  
  if(!(PluginIntegrationTest($_GET['testPlugin']) == false)){
    die('ok');
  }else{
    die();
  }
}

function PluginIntegrationTest($PluginPath){
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
    return true;
  }else{
    return false;
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
        $ASTRIA['plugin'][$Plugin]=array('state' => 'test','name' => $Plugin,'data'=>array());
      }
      SavePluginConfig();
    }
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

function PluginsArchitectHomepage(){
  global $ASTRIA;
  ?><h2>Plugins</h2>
  <p><a href="/?testPlugins" class="btn btn-outline-success">Test Plugins</a></p>
<?php
  foreach($ASTRIA['plugin'] as $Index => $Plugin){
    ?>

<div class="card">
  <div class="card-block">
    <h4 class="card-title"><?php echo $Plugin['name']; ?></h4>
    <div class="card-text">
      <p><b>State:</b> <?php echo $Plugin['state']; ?></p>
      
    </div>
  </div>
</div>

    <?php
  }
}
