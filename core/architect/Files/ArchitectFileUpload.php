<?php

function ArchitectFileUpload(){
  if(isset($_POST['destination'])){
    
    
    $target_dir = $_POST['destination'];
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        die("Sorry, your file was not uploaded.");
        
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          Event('Upload Succeeded');
          header('Location: /architect/files/?path='.$_POST['redirect']);
          exit;
        } else {
          die("Sorry, there was an error uploading your file.");
        }
    }

  }
  TemplateBootstrap4('Upload File - Architect','ArchitectFileUploadBodyCallback();'); 
}

function ArchitectFileUploadBodyCallback(){
  
  ?>
  
  <h1>Upload File</h1>
  <form action="/architect/files/upload/" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="redirect" value="<?php echo $_GET['path']; ?>">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="text" class="form-control" name="destination" id="destination" value="<?php echo $_SERVER['DOCUMENT_ROOT']; if(isset($_GET['path'])){echo $_GET['path'];} ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Create File">
  </form>
  
  <?php
}
