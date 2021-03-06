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
  
  TemplateBootstrap4('View Cache - Architect'); 
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
                echo '<a href="/architect/disk-cache/'.$hash.'">'.$hash.'</a> ('.(filesize($path.$file)/1024).'kb) (Age '.(time()-filemtime($path.$file)).')<br>';
              }
            }
          }
        }
      }else{
        pd(readDiskCache($hash));
        
        echo "<br>$path='cache/'.$hash.'.php';<br><br>";
        $path='cache/'.$hash.'.php';
        pd($path);
        echo '<br><br>$value=file_get_contents($path);<br>';
        $value=file_get_contents($path);
        pd($value);
        echo '<br><br>$value=ltrim($value,DISK_CACHE_FILE_PREFIX);<br>';
        $value=ltrim($value,DISK_CACHE_FILE_PREFIX);
        pd($value);
        echo '<br><br>$value=rtrim($value,DISK_CACHE_FILE_SUFFIX);<br>';
        $value=rtrim($value,DISK_CACHE_FILE_SUFFIX);
        pd($value);
        echo '<br><br>$value=BlowfishDecrypt($value);<br>';
        $value=BlowfishDecrypt($value);
        pd($value);
        echo '<br><br>$value=unserialize($value);<br>';
        $value=unserialize($value);
        pd($value);
        
      }
    ?>
  </div>
<?php
}
