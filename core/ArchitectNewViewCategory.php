<?php
function ArchitectNewViewCategory(){
  if(isset($_POST['newViewCategoryName'])){
    global $ASTRIA;
    
    MakeSureDBConnected();
    
    $newViewCategoryName   = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['newViewCategoryName']);
    $newViewDescription    = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['newViewCategoryDescription']);
    $newViewCategoryParent = intval($_POST['newViewCategoryParent']);
    if($newViewCategoryParent==0){$newViewCategoryParent='null';}
    
    $sql="INSERT INTO `ViewCategory` (`ParentID`, `Name`, `Description`,`InsertedTime`,`InsertedUser`) VALUES (".$newViewCategoryParent.", '".$newViewName."', '".$newViewDescription."',NOW(),".intval($ASTRIA['Session']['User']['UserID']).");";
    Query($sql);
    
    $ViewCategoryID=mysqli_insert_id($ASTRIA['databases']['astria']['resource']);
    
    header('Location: /architect/edit-view-category/'.$ViewID);
    exit;
    
  }
  
  Hook('Template Body','ArchitectNewViewCategoryBodyCallback();');
  TemplateBootstrap4('New View Category - Architect'); 
}
  
function ArchitectNewViewCategoryBodyCallback(){
?><h1>New View Category</h1>
<div class="row">
  <div class="col-xs-12">
    <form action="/architect/new-view-category" method="post">
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="View Category Name" name="newViewCategoryName" id="newViewCategoryName">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Description" name="newViewCategoryDescription" id="newViewCategoryDescription">
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-xs-12">
          <select class="form-control" placeholder="Category" name="newViewCategoryParent" id="newViewCategoryParent">
            <?php
              MakeSureDBConnected();
              $ViewCategories=Query("SELECT * FROM ViewCategory");
              foreach($ViewCategories as $ViewCategory){
            ?>
            <option <?php
                if(isset($_GET['parent'])&&$_GET['parent']==$ViewCategory['ViewCategoryID']){
                  echo ' selected="selected"';
                }
            ?>value="<?php echo $ViewCategory['ViewCategoryID']; ?>"><?php echo $ViewCategory['Name']; ?></option>
            <?php 
              }
            ?>
          </select>
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success">Create View Category</button>
        </div>
      </div>
    </form>
  </div>
  <script>
    $('#newViewCategoryName').focus();
  </script>
</div>
<?php
}
