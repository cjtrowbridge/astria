<?php

function ArchitectSchemaAdd(){
  if(isset($_POST['dbHost'])){
    
    $NewAlias = preg_replace("/^[a-zA-Z0-9_]+([-.][a-zA-Z0-9_]+)*$/", "", $_POST['dbAlias']);
    if($NewAlias=='astria'){
      die('Nonprimary schema can not be aliased to "astria".');
    }
    
    global $ASTRIA;
    $newSchemaFile="<?php ".PHP_EOL."global \$ASTRIA;".PHP_EOL;
    foreach($ASTRIA['databases'] as $Index => $Plugin){
      if($Index != 'astria'){
        $newSchemaFile.=PHP_EOL.PHP_EOL.
          "\$ASTRIA['databases']['".$NewAlias."'] = array(";
          "  'type'                     => 'mysql',".PHP_EOL.
          "  'hostname'                 => 'localhost',".PHP_EOL.
          "  'username'                 => 'secscidata',".PHP_EOL.
          "  'password'                 => 'fzTRbSZWa7Rpjjeg',".PHP_EOL.
          "  'database'                 => 'securities.science.data',".PHP_EOL.
          "  'resource'                 => false".PHP_EOL.
          ");".PHP_EOL.PHP_EOL;
      }
    }
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
