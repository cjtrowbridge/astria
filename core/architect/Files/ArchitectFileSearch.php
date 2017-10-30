<?php

function ArchitectFileSearch(){
  
  TemplateBootstrap4('File Search - Architect','ArchitectFileCopyRemoteBodyCallback();'); 
}
function ArchitectFileCopyRemoteBodyCallback(){
  ?>
  
  <h1>File Search</h1>
  <form action="/architect/files/search/" method="get" class="form">
    <div class="row">
      <div class="col-xs-12 col-lg-6">
        Path:<br>
        <input type="text" class="form-control" name="path" id="pat" value="<?php echo $_SERVER['DOCUMENT_ROOT']; if(isset($_GET['path'])){echo $_GET['path'];} ?>"><br>
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
    
    $Path = $_GET['path'];
    $PAth = realpath($Path);
    if(!(is_dir($Path))){
      echo "Path is not a directory!";
      exit;
    }
    
    $Query = $_GET['query'];
    $Query = preg_match('/^[a-z0-9 \-]+$/i', $Query);
    
    $Command = 'grep -R "'.$Query.'" '.$Path;
    pd($Command);
    
    $Results = shell_exec($Command);
    pd($Results);
    
  }
}
