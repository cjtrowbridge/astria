<?php

function ArchitectFileSearch(){
  
  TemplateBootstrap4('File Search - Architect','ArchitectFileCopyRemoteBodyCallback();'); 
}
function ArchitectFileCopyRemoteBodyCallback(){
  ?>
  
  <h1>File Search</h1>
  <form action="/architect/files/search/" method="get" class="form">
    <label>
      Path:
      <input type="text" class="form-control" name="path" id="pat" value="<?php echo $_SERVER['DOCUMENT_ROOT']; if(isset($_GET['path'])){echo $_GET['path'];} ?>"><br>
    </label>
    <label>
      Query: (Only alphanumeric characters and spaces are allowed)
      <input type="text" class="form-control" name="query" id="query" value="<?php echo if(isset($_GET['query'])){echo $_GET['query'];} ?>" placeholder="Query"><br>
    </label>
    <input type="submit" class="btn btn-block btn-success" value="File Search">
  </form>
  <script>
    $('#query').focus();
  </script>

  <?php
  
  if(isset($_GET['query'])){
    echo '<h2>Search Results</h2>';
    
    $Path = $_GET['path'];
    if(!(is_dir($Path))){
      echo "Path is not a directory!";
      exit;
    }
    
    $Query = $_POST['query'];
    $Query = preg_match('/^[a-z0-9 \-]+$/i', $Query);
    $Results = shell_exec('grep -R "'.$Query.'"');
    
    pd($Results);
    
  }
}
