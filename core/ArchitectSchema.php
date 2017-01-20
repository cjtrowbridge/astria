<?php

function showArchitectSchema(){
  Hook('Template Body','ArchitectSchemaBodyCallback();');
  TemplateBootstrap4('Schema | Architect'); 
}
  
function ArchitectSchemaBodyCallback(){
?>
<h2>Schema Architect</h2>
<div class="row">
  <div class="col-xs-12">
    <form class="form-inline">
      <button onclick="Cardify('New Schema','newSchema');" type="button" class="btn btn-outline-warning">New Schema</button>
    </form>
  </div>
</div><br>
<div class="row">
  <div class="hidden" id="newSchema">
    <form action="/architect/schema/new" method="post">
      <div class="form-group row">
        <div class="col-xs-12">
          What would you call one object in this schema?<br>
          (Ie, Cats would be "Cat." Alphanumeric characters only.)<br>
          <input type="text" class="form-control" placeholder="Schema Object Name" name="newSchemaObject" id="newSchemaObject">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <div class="form-check">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox" name="newSchemaVersioning" id="newSchemaVersioning" value="yes" checked="checked">
              Track version and history for this Schema.
            </label>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success">Create Schema</button>
        </div>
      </div>
    </form>
  </div>
</div>


<?php
}
