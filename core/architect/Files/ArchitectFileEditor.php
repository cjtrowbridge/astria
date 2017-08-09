<?php
function ArchitectFileEditor(){
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
  
  $Contents     = file_get_contents($Path);
  $TextareaName = 'newContents'; 
  
  AstriaEditor($Contents,$TextareaName);
  
}
