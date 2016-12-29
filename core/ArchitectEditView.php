<?php

function ArchitectEditView(){
  Hook('Template Body','ArchitectEditViewBodyCallback();');
  TemplateBootstrap2('Architect'); 
}
function ArchitectEditViewBodyCallback(){
  global $ASTRIA;
  MakeSureDBConnected();
  
  pd(path(2));
  
  if(is_integer(trim(path(2)))){
    //look up by id
    $sql="
      SELECT * FROM View 
      LEFT JOIN Hook ON Hook.ViewID = View.ViewID
      LEFT JOIN Callback ON Callback.CallbackID = Hook.CallbackID
      WHERE View.ViewID = ".intval(path(2))."
    ";
    die($sql);
    $View=Query($sql);
  }else{
    //try looking up by slug
    $safeslug=mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],path(2));
    $sql="
      SELECT * FROM View 
      LEFT JOIN Hook ON Hook.ViewID = View.ViewID
      LEFT JOIN Callback.CallbackID = Hook.CallbackID
      WHERE View.Slug LIKE '".$safeslug."'
    ";
    $View=Query($sql);
  }
  if(!(isset($View[0]))){
    echo '<h1>View Not Found!</h1>';
    return false;
  }
  pd($View);
  ?>

<div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>Edit View: <?php echo $View['Name']; ?></h1>
        
        
        <form action="/architect/edit-view/" method="post">
          
          <h2>The View</h2>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">View Name:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="viewName" value="<?php echo $View['Name']; ?>" id="viewName">
            </div>
          </div>
          <script>
            $('#viewName').focus();
          </script> 
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">View Slug:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="slug" value="<?php echo $View['Slug']; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Description:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="viewDescription" value="<?php echo $View['Description']; ?>">
            </div>
          </div>
          
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Groups:</label>
            <div class="col-xs-10">
              ???
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Hooks and Callbacks:</label>
            <div class="col-xs-10">
              ???
            </div>
          </div>
          <input class="form-control" type="submit">
        </form>
        <br>
        <br>
      </div>
    </div>
</div>




<?php
  
}
