<?php

function ArchitectFileMove(){
  
  if(isset($_POST['newDirectoryPath'])){
    if(
      mkdir($_SERVER['DOCUMENT_ROOT'].$_POST['newDirectory'],0775)
      ==false
    ){
      die('<p>Unable to create: '.$_GET['path'].'</p>');
    }
    header('Location: /architect/files/?path='.$_POST['newDirectory']);
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
  <form action="/architect/files/move/" method="post" class="form">
    <input type="text" class="form-control" name="moveFrom" id="MoveFrom" value="<?php echo $_GET['path']; ?>"><br>
    <input type="text" class="form-control" name="moveTo" id="moveTo" value="<?php echo $_GET['path']; ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Move">
  </form>
  
  <?php
}
