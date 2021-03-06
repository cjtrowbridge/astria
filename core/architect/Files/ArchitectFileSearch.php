<?php

function ArchitectFileSearch(){
  
  TemplateBootstrap4('File Search - Architect','ArchitectFileCopyRemoteBodyCallback();'); 
}
function ArchitectFileCopyRemoteBodyCallback(){
  
  if(isset($_GET['path'])){
    $Path = $_GET['path'];
    $Path = realpath($Path);
    if($Path==''){
      $Path = realpath($_SERVER['DOCUMENT_ROOT'].$_GET['path']);
    }
    $_GET['path']=$Path;
  }
  ?>
  
  <h1>File Search</h1>
  <form action="/architect/files/search/" method="get" class="form">
    <div class="row">
      <div class="col-xs-12 col-lg-6">
        Path:<br>
        <input type="text" class="form-control" name="path" id="path" value="<?php if(isset($_GET['path'])){echo $_GET['path'];} ?>"><br>
      </div>
      <div class="col-xs-12 col-lg-6">
        Query: (Only alphanumeric characters and spaces are allowed)<br>
        <input type="text" class="form-control" name="query" id="query" value="<?php if(isset($_GET['query'])){echo $_GET['query'];} ?>" placeholder="Query"><br>
      </div>
    <input type="submit" class="btn btn-block btn-success" value="File Search">
  </form>
  <script>
    $('#query').focus();
  </script>

  <?php
  
  if(isset($_GET['query'])){
    echo '<h2>Search Results</h2>';
    
    if(!(is_dir($Path))){
      echo "Path '".$Path."' is not a directory.";
      return;
    }
    
    $Query = $_GET['query'];
    $Query = preg_replace("/[^A-Za-z0-9 ]/", "", $Query);

    $Command = 'grep -RHon "'.$Query.'" '.$Path;
    echo '<h2>'.$Command.'</h2>';
    
    $Results = shell_exec($Command);
    $Results = explode(PHP_EOL,$Results);
    
    foreach($Results as $Result){
      $Parts = explode(':',$Result);
      echo '<p><a href="/architect/files/?path='.str_replace($_SERVER['DOCUMENT_ROOT'],'',$Parts[0]).'" target="_blank">'.$Parts[0].'('.$Parts[1].')</a></p>'.PHP_EOL;
      
    }
    
  }
}
