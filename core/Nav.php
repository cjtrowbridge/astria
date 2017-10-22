<?php

global $ASTRIA;
$ASTRIA['nav']=array();

function Nav($Which,$Type,$Text,$Link,$Children = null){
  if($Children==null){
    $Children=array();
  }
  
  global $ASTRIA;
  if(!isset($ASTRIA['nav'][strtolower($Which)])){
    $ASTRIA['nav'][strtolower($Which)]=array();
  }
    
  $ASTRIA['nav'][strtolower($Which)][]=array(
    'type'     => strtolower($Type),
    'text'     => $Text,
    'link'     => $Link,
    'children' => $Children
  );
}

function ShowNav($Which){
  global $ASTRIA;
  if(isset($_GET['verbose'])){
    echo "\n<!--\n";
    pd($ASTRIA['nav']);
    echo "\n-->\n";
  }
  if(
    isset($ASTRIA['nav'])&&
    isset($ASTRIA['nav'][strtolower($Which)])
  ){
    foreach($ASTRIA['nav'][strtolower($Which)] as $Nav){
      if(strtolower($Nav['type'])=='post-query'){
      ?>
           
        <li class="nav-item">
          <form action="<?php echo $Nav['link']; ?>" method="post">
            <input class="form-control" type="text" name="<?php echo $Nav['text']; ?>">
          </form>
        </li>
 
      <?php
      }
      if(strtolower($Nav['type'])=='get-query'){
      ?>
           
        <li class="nav-item">
          <form action="<?php echo $Nav['link']; ?>" method="get">
            <input class="form-control" type="text" name="<?php echo $Nav['text']; ?>">
          </form>
        </li>
 
      <?php
      }
      if(strtolower($Nav['type'])=='link'){
      ?>
           
        <li class="nav-item<?php if(path()==ltrim($Nav['link'],"/")){ echo ' active';} ?>">
          <a class="nav-link" href="<?php echo $Nav['link']; ?>"><?php echo $Nav['text']; ?></a>
        </li>
 
      <?php
      }
      if(strtolower($Nav['type'])=='dropdown'){
      ?>
      
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="<?php echo $Nav['link']; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $Nav['text']; ?></a>
          <div class="dropdown-menu">
            
            <?php
            foreach($Nav['children'] as $Child){
              if($Child['text']=='divider'){
              ?>
            
              <div class="dropdown-divider"></div>
            
              <?php
              }else{
              ?>
            
              <a class="dropdown-item" href="<?php echo $Child['link']; ?>"><?php echo $Child['text']; ?></a>
            
              <?php
                }
              } 
              ?>
            
          </div>
        </li>
      
      <?php
      }
    }
  }
}
