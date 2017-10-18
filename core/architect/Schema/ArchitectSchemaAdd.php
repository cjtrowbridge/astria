<?php

function ArchitectSchemaAdd(){
  if(isset($_POST['dbHost'])){
    
    $NewAlias = preg_replace("/^[a-zA-Z0-9_]+([-.][a-zA-Z0-9_]+)*$/", "", $_POST['dbAlias']);
    if($NewAlias=='astria'){
      die('Nonprimary schema can not be aliased to "astria".');
    }
    
    global $ASTRIA;
    $newSchemaFile="<?php ".PHP_EOL."global \$ASTRIA;".PHP_EOL;
    foreach($ASTRIA['databases'] as $Index => $Schema){
      if(true||$Index != 'astria'){
        $newSchemaFile.=PHP_EOL.PHP_EOL.
        "\$ASTRIA['databases']['".$Index."'] = array(".
        "  'type'                     => '".$Schema['type']."',    ".PHP_EOL.
        "  'hostname'                 => '".$Schema['hostname']."',".PHP_EOL.
        "  'username'                 => '".$Schema['username']."',".PHP_EOL.
        "  'password'                 => '".$Schema['password']."',".PHP_EOL.
        "  'database'                 => '".$Schema['database']."',".PHP_EOL.
        "  'resource'                 => false".PHP_EOL.
        ");".PHP_EOL.PHP_EOL;
      }
    }
    
    $newSchemaFile.=PHP_EOL.PHP_EOL.
    "\$ASTRIA['databases']['".$NewAlias."'] = array(".
    "  'type'                     => '".$_POST['dbType']."',    ".PHP_EOL.
    "  'hostname'                 => '".$_POST['dbHost']."',".PHP_EOL.
    "  'username'                 => '".$_POST['dbUsername']."',".PHP_EOL.
    "  'password'                 => '".$_POST['dbPassword']."',".PHP_EOL.
    "  'database'                 => '".$_POST['dbName']."',".PHP_EOL.
    "  'resource'                 => false".PHP_EOL.
    ");".PHP_EOL.PHP_EOL;
    
    $result=false;
    //$result=file_put_contents('schema.php', $newSchemaFile);
    if($result==false){
     die("Could not write schema config file. Please give write permission or copy the following into a new schema.php file;\n\n".$newSchemaFile); 
    } 
    
    header('Location: /architect/schema');
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
      <label class="col-xs-2 col-form-label">Database Type:</label>
      <div class="col-xs-10">
        <select class="form-control" name="dbType">
          <option value="mysql">MySQL</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-xs-2 col-form-label">Database Alias:</label>
      <div class="col-xs-10">
        <input class="form-control" type="text" name="dbAlias" id="dbAlias">
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
    $('#dbAlias').focus();
  </script>
<?php
}
