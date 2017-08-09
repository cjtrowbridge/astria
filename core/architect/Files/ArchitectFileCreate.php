<?php

function ArchitectFileCreate(){
  TemplateBootstrap4('File Editor - Architect','ArchitectFileCreateBodyCallback();'); 
}
function ArchitectFileCreateBodyCallback(){
  ?>
  
  <h1>Create File</h1>
  <form action="/architect/files/edit/" method="get" class="form">
    <input type="text" class="form-control" name="path" id="path" value="<?php echo $_GET['path']; ?>"><br>
    <input type="submit" class="btn btn-block btn-success" value="Create File">
    <script>
      $('form').submit(function(event){
        var Path = $('#path').val();
        window.location='/architect/files/edit/?path='+Path;
        event.preventDefault();
      });
    </script>
  </form>
  
  <?php
}
