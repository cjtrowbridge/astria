<?php
function ArchitectEditViewCategory(){
  if(isset($_POST['ViewCategoryID'])){
    global $ASTRIA;
    
    MakeSureDBConnected();
    
    $ViewCategoryID     = intval($_POST['ViewCategoryID']);
    $ViewCategoryName   = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['ViewCategoryName']);
    $ViewDescription    = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['ViewCategoryDescription']);
    $ViewCategoryParent = intval($_POST['ViewCategoryParent']);
    if($ViewCategoryParent==0){$ViewCategoryParent='null';}
    if($ViewCategoryParent==$ViewCategoryID){die('A category can not be its own parent!');}
    
    $sql="UPDATE `ViewCategory` SET `ParentID` = ".$ViewCategoryParent.", `Name` = '$ViewCategoryName', `Description` = '".$ViewDescription."', `UpdatedUser` = '".intval($ASTRIA['Session']['User']['UserID'])."', `UpdatedTime` = NOW() WHERE `ViewCategory`.`ViewCategoryID` = ".$ViewCategoryID.";";
    Query($sql);
    
    header('Location: /architect/edit-view-category/'.$ViewCategoryID);
    exit;
    
  }
  
  //Validate the view we are editing
  
  
  Hook('Template Body','ArchitectEditViewCategoryBodyCallback();');
  TemplateBootstrap4('Edit View Category - Architect'); 
}
  
function ArchitectEditViewCategoryBodyCallback(){
?><h1>Edit View Category</h1>
<div class="row">
  <div class="col-xs-12">
  <?php
    $ViewCategory=Query('SELECT * FROM ViewCategory WHERE ViewCategoryID = '.intval(path(2)));
    if(!(isset($ViewCategory[0]))){die('Invalid View Category');}
    $ViewCategory=$ViewCategory[0];
  
  ?>
    <form action="/architect/edit-view-category" method="post">
      <input type="hidden" id="ViewCategoryID" name="ViewCategoryID" value="<?php echo $ViewCategory['ViewCategoryID']; ?>">
      <div class="form-group row">
        <div class="col-xs-12">
          Name:<br>
          <input type="text" class="form-control" placeholder="View Category Name" name="ViewCategoryName" id="ViewCategoryName" value="<?php echo $ViewCategory['Name']; ?>">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Description" name="ViewCategoryDescription" id="ViewCategoryDescription" value="<?php echo $ViewCategory['Description']; ?>">
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-xs-12">
          <select class="form-control" placeholder="Category" name="ViewCategoryParent" id="ViewCategoryParent">
            <option value="">Root Category (No Parent)</option>
            <?php
              MakeSureDBConnected();
              $ViewCategories=Query("SELECT * FROM ViewCategory");
              foreach($ViewCategories as $ViewCategoryOptions){
                if(!($ViewCategory['ViewCategoryID']==$ViewCategoryOptions['ViewCategoryID'])){
            ?>
            <option <?php
                if($ViewCategory['ParentID']==$ViewCategoryOptions['ViewCategoryID']){
                  echo ' selected="selected"';
                }
            ?>value="<?php echo $ViewCategoryOptions['ViewCategoryID']; ?>"><?php echo $ViewCategoryOptions['Name']; ?></option>
            <?php 
                }
              }
            ?>
          </select>
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success">Update View Category</button>
        </div>
      </div>
    </form>
  </div>
  <script>
    $('#ViewCategoryName').focus();
  </script>
</div>
<?php
}
