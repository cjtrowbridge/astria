<?php

function ArchitectFileMove(){
  
  if(isset($_POST['moveTo'])){
    if(
      rename($_POST['moveFrom'],$_SERVER['DOCUMENT_ROOT'].$_POST['moveTo'])
      ==false
    ){
      die('<p>Unable to move: '.$_GET['path'].'</p>');
    }
    header('Location: /architect/files/?path='.basename($_POST['newDirectory']));
    exit;
  }
  
  if(
    (!(isset($_GET['path'])))||
    ($_GET['path']=='')
  ){
    header('Location: /architect/files/?path=/');
    exit;
  }
  TemplateBootstrap4('Move - Architect','ArchitectFileMoveBodyCallback();'); 
}
function ArchitectFileMoveBodyCallback(){
  ?>
  
  <h1>Move</h1>
  <form action="/architect/files/move/?path=<?php echo $_GET['path']; ?>" method="post" class="form">
    <input type="text" class="form-control" name="moveFrom" id="MoveFrom" value="<?php echo $_SERVER['DOCUMENT_ROOT'].$_GET['path']; ?>"><br>
    <input type="text" class="form-control" name="moveTo" id="moveTo" value="<?php echo $_SERVER['DOCUMENT_ROOT'].$_GET['path']; ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Move">
  </form>
  
  <?php
}
