<?php

function ArchitectRepositoryClone(){
  
  if(isset($_POST['origin'])){
    /*
    if(mkdir($_SERVER['DOCUMENT_ROOT'].$_POST['newDirectory'],0775)==false){
      die('<p>Unable to create: '.$_GET['path'].'</p>');
    }
    header('Location: /architect/files/?path='.$_POST['newDirectory']);
    */
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
    <input type="text" class="form-control" name="origin" id="origin"><br>
    <p><b>Note:</b> This might take a while if it is really big or complicated. Don't refresh or click again or IDK what will happen D:</p>
    <input type="submit" class="btn btn-block btn-success" value="Clone Repository">
  </form>
  
  <?php
}
