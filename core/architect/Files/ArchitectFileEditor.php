<?php
function ArchitectFileEditor(){
  if(isset($_POST['newContents'])){
    pd($_POST);
    exit;
  }
  
  if(
    (!(isset($_GET['path'])))||
    ($_GET['path']=='')
  ){
    header('Location: /architect/files/edit?path=/');
    exit;
  }
  
  TemplateBootstrap4('File Editor - Architect','ArchitectFileEditorBodyCallback();'); 
}
function ArchitectFileEditorBodyCallback(){
  //TODO check for escape attempts
  
  echo '<h1>Editing: <a href="/architect/files/?path=/">Astria</a>:'.$_GET['path'].'</h1>'.PHP_EOL;
  
  if(is_file($_SERVER['DOCUMENT_ROOT'].$_GET['path'])){
    ArchitectFileEdit($_GET['path']);
  }else{
    echo '<p>Invalid Path: '.$_SERVER['DOCUMENT_ROOT'].$_GET['path'].'</p>';
    
  }
  
}
          
function ArchitectFileEdit($Path){
  ?>

  <form action="/architect/files/edit" method="post" class="form">
    <input hidden name="path" value="<?php echo $Path; ?>">
    
  <?
  $Contents     = file_get_contents($_SERVER['DOCUMENT_ROOT'].$Path);
  $TextareaName = 'newContents'; 
  
  AstriaEditor($Contents,$TextareaName);
  
  ?>
  
    <input type="submit" class="btn btn-success">
  </form>
  
  <?php
}
