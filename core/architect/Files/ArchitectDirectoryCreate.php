<?php
function ArchitectDirectoryCreate(){
  if(isset($_POST)){
    pd($_POST);
    exit;
  }
  TemplateBootstrap4('Create Directory - Architect','ArchitectDirectoryCreateBodyCallback();'); 
}
function ArchitectDirectoryCreateBodyCallback(){
  ?>
  
  <h1>Create Directory</h1>
  <form action="/architect/files/create-directory/" method="post" class="form">
    <input type="text" class="form-control" name="path" id="path" value="<?php echo $_GET['path']; ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Create Directory">
  </form>
  
  <?php
}
