<?php
function ArchitectFileEditor(){
  if(isset($_POST['newContents'])){
    $Result = file_put_contents($_SERVER['DOCUMENT_ROOT'].$_POST['path'],$_POST['newContents']);
      //TODO make this prettier and suggest fixes
      echo '<h1>Failed To Save Changes</h1>';
      if($Result == false){
      pd($Result);
      pd($_POST);
      exit;
    }
    
    header('Location: /architect/files/?path='.$_POST['path']);
    exit;
  }
  
  if(
    (!(isset($_GET['path'])))||
    ($_GET['path']=='')
  ){
    header('Location: /architect/files/edit?path=/');
    exit;
  }
  
  TemplateBootstrap4('File Editor - Architect','ArchitectFileEditorBodyCallback();',true); 
}
function ArchitectFileEditorBodyCallback(){
  //TODO check for escape attempts
  
  echo '<h4 style="padding:0;line-height: 1.25em;>Editing: <a href="/architect/files/?path=/">Astria</a>:'.$_GET['path'].'</h4>'.PHP_EOL;
  
  if(is_file($_SERVER['DOCUMENT_ROOT'].$_GET['path'])){
    ArchitectFileEdit($_GET['path']);
  }else{
    if(is_dir(dirname($_SERVER['DOCUMENT_ROOT'].$_GET['path']))){
      //New File
      ArchitectFileEdit($_GET['path']);
    }else{
      //File does not exist, and parent directory does not exist
      echo '<p>Invalid Path: '.$_SERVER['DOCUMENT_ROOT'].$_GET['path'].'</p>';
    }
  }
  
}
          
function ArchitectFileEdit($Path){
  
  if(
    (is_dir(dirname($_SERVER['DOCUMENT_ROOT'].$_GET['path'])))&&
    (!(is_file($_SERVER['DOCUMENT_ROOT'].$_GET['path'])))
  ){
    $Contents     = '';
    $TextareaName = 'newContents'; 
  }else{
    $Contents     = file_get_contents($_SERVER['DOCUMENT_ROOT'].$Path);
    $TextareaName = 'newContents'; 
  }
  
?>

  <form action="/architect/files/edit" method="post" class="form">
    <input hidden name="path" value="<?php echo $Path; ?>">
    
  <?php
  
  
  AstriaEditor($Contents,$TextareaName);
  
  ?>
    <br>
    <input type="submit" class="btn btn-sm btn-success" value="Save Changes"><br>
  </form>
  
  <?php
}
