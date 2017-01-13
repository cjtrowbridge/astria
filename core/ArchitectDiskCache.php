<?php 

function showArchitectDiskCache(){
  if(path(2)=='delete-all'){
    //TODO
  }
  if(DiskCacheExists(path(2))){
    Hook('Template Body',"ArchitectDiskCache('".path(2)."');");
  }else{
    Hook('Template Body',"ArchitectDiskCache();");
  }
  
  TemplateBootstrap2('View Cache - Architect'); 
}

function ArchitectDiskCache($hash = false){
  ?>
  <h2>Disk Cache</h2>
  <div class="col-xs-12">
    <a href="/architect/disk-cache/delete-all">Delete All</a>
  </div>
  <div class="col-xs-12">
    <?php
      global $ASTRIA;
      $path = 'cache/';
      if($hash==false){
        if ($handle = opendir($path)) {
          while (false !== ($file = readdir($handle))) {
            if(!(strpos($file, '.php')===false)){
              $hash = rtrim($file,'.php');
              if(!($hash == 'index')){
                echo '<a href="/architect/disk-cache/'.$hash.'">'.$hash.'</a> ('.(filesize($path.$file)/1024).'kb)<br>';
              }
            }
          }
        }
      }else{
        pd(readDiskCache($hash));

      }
    ?>
  </div>
<?php
}
