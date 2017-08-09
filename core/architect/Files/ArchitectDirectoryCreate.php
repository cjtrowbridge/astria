<?php
function ArchitectDirectoryCreate(){
  if(isset($_POST['newDirectory'])){
    if(mkdir($_SERVER['DOCUMENT_ROOT'].$_POST['newDirectory'],775)==false){
      die('<p>Unable to create: '.$_GET['path'].'</p>');
    }
    header('Location: /architect/files/?path='.$_POST['newDirectory']);
    exit;
  }
  TemplateBootstrap4('Create Directory - Architect','ArchitectDirectoryCreateBodyCallback();'); 
}
function ArchitectDirectoryCreateBodyCallback(){
  ?>
  
  <h1>Create Directory</h1>
  <form action="/architect/files/create-directory/" method="post" class="form">
    <input type="text" class="form-control" name="newDirectory" id="newDirectory" value="<?php echo $_GET['path']; ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Create Directory">
  </form>
  
  <?php
}
