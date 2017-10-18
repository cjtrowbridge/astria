<?php

function ArchitectSchemaAdd(){
  if(isset($_POST['dbHost'])){
    pd($_POST);
    exit;
  }
  TemplateBootstrap4('Add Schema','ArchitectSchemaAddBodyCallback();');
}

function ArchitectSchemaAddBodyCallback(){
?><h1><A href="/architect">Architect</a> / <a href="/architect/schema">Schema</a> / <a href="/architect/schema/add">Add</a></h1>

  <form action="/architect/schema/add" method="post">
    <div class="form-group row">
      <label class="col-xs-2 col-form-label">Database Hostname:</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" name="dbHost" value="localhost">
        <small class="form-text text-muted">This is usually localhost, but it cann be any hostname, IP, etc..</small>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-xs-2 col-form-label">Database Username:</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" name="dbUsername" id="dbUsername">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-xs-2 col-form-label">Database Password:</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" name="dbPassword">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-xs-2 col-form-label">Database Name:</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" name="dbName">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-12">
        <input type="submit" value="add" class="btn btn-block btn-success">
      </div>
    </div>
  </div>
  <script>
    $('#dbUsername').focus();
  </script>
<?php
}
