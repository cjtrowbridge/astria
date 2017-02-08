<?php

function ArchitectNewView(){
  if(isset($_POST['newViewName'])){
    global $ASTRIA;
    
    MakeSureDBConnected();
    
    $newViewName         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['newViewName']);
    $newViewDescription  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['newViewDescription']);
    $newViewSlug         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['newViewSlug']);

    $sql="INSERT INTO `View` (`Slug`, `Name`, `Description`,`InsertedTime`,`InsertedUser`) VALUES ('".$newViewSlug."', '".$newViewName."', '".$newViewDescription."',NOW(),".intval($ASTRIA['Session']['User']['UserID']).");";
    Query($sql);
    $ViewID=mysqli_insert_id($ASTRIA['databases']['astria']['resource']);
    
    header('Location: /architect/edit-view/'.$ViewID);
    exit;
    
  }
  
  Hook('Template Body','ArchitectNewViewBodyCallback();');
  TemplateBootstrap4('New View - Architect'); 
}
  
function ArchitectNewViewBodyCallback(){
?><h1>New View</h1>
<div class="row">
  <div class="col-xs-12">
    <form action="/architect/new-view" method="post">
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="View Name" name="newViewName" id="newViewName">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Description" name="newViewDescription" id="newViewDescription">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Slug" name="newViewSlug" id="newViewSlug">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          Category:<br>
          <select class="form-control" placeholder="Category" name="newViewCategory" id="newViewCategory">
            <?php
              MakeSureDBConnected();
              $ViewCategories=Query("SELECT * FROM ViewCategory");
              foreach($ViewCategories as $ViewCategory){
            ?>
            <option value="<?php echo $ViewCategory['ViewCategoryID']; ?>"><?php echo $ViewCategory['Name']; ?></option>
            <?php 
              }
            ?>
          </select>
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success">Create View</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
}

