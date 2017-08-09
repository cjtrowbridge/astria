<?php

function ArchitectFileCreate(){
  TemplateBootstrap4('File Editor - Architect','ArchitectFileCreateBodyCallback();'); 
}
function ArchitectFileCreateBodyCallback(){
  ?>
  
  <h1>Create File</h1>
  <form action="/architect/files/edit/" method="get" class="form" onsubmit="CreateFile();">
    <input type="text" class="form-control" name="path" id="path" value="<?php echo $_GET['path']; ?>"><br>
    <a hreaf="javascript:void(0);" class="btn btn-block btn-success" onclick="CreateFile();">Create File</a>
    <script>
      function CreateFile(){
        var Path = $('#path').val();
        window.location='/architect/files/edit/?path='+Path;
      }
    </script>
  </form>
  
  <?php
}
