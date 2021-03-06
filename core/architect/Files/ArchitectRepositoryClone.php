<?php

function ArchitectRepositoryClone(){
  
  if(isset($_POST['origin'])){
    $Command = 'cd '.$_SERVER['DOCUMENT_ROOT'].$_POST['pwd'].' && git clone '.$_POST['origin'];
    //echo '<pre>Executing: '.$Command.PHP_EOL;
    shell_exec($Command);
    //echo '</pre><a href="/architect/files/?path='.$_POST['pwd'].'">Continue</a>';
    
    header('Location: /architect/files/?path='.$_POST['pwd']);
    exit;
  }
  
  if(
    (!(isset($_GET['path'])))||
    ($_GET['path']=='')
  ){
    header('Location: /architect/files/?path=/');
    exit;
  }
  TemplateBootstrap4('Clone Repository - Architect','ArchitectRepositoryCloneBodyCallback();'); 
}
function ArchitectRepositoryCloneBodyCallback(){
  ?>
  
  <h1>Clone Repository</h1>
  <form action="/architect/files/clone-repository/" method="post" class="form">
    Origin:<br>
    <input type="text" class="form-control" name="origin" id="origin"><br>
    Into:</br>
    <input type="text" class="form-control" name="pwd" id="pwd" value="<?php echo $_GET['path']; ?>"><br>
    <p><b>Note 1:</b> This will literally call 'cd [into] && git clone [origin]'. There is no sanitation. And it's going to make a subdirectory. Alternatively, you can add an argument to the origin field which will be appended to the command. Keep in mind this will create a subdirectory unless you specify otherwise.</p>
    <p><b>Note 2:</b> This might take a while if it is really big or complicated. Don't refresh or click again or IDK what will happen D:</p>
    <input type="submit" class="btn btn-block btn-success" value="Clone Repository">
  </form>
  
  <?php
}
