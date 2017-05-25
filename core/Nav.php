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
  echo "\n<!--\n";
  pd($ASTRIA['nav']);
  echo "\n-->\n";
  if(
    isset($ASTRIA['nav'])&&
    isset($ASTRIA['nav'][strtolower($Which)])
  ){
    foreach($ASTRIA['nav'][strtolower($Which)] as $Nav){
      if(strtolower($Nav['type'])=='link'){
      ?>
           
        <li class="nav-item<?php if(path()==ltrim($Nav['link'],"/")){ echo ' active';} ?>">
          <a class="nav-link" href="<?php echo $Nav['link']; ?>"><?php echo $Nav['text']; ?></a>
        </li>
 
      <?php
      }
      if(strtolower($Nav['type'])=='dropdown){
      ?>
      
      <div class="dropdown show">
        <a class="btn btn-secondary dropdown-toggle" href="<?php echo $Nav['link']; ?>" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $Nav['text']; ?>
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <?php
            foreach($Nav['Children'] as $Child){
          ?>
          <a class="dropdown-item" href="<?php echo $Child['link']; ?>"><?php echo $Child['text']; ?></a>
          <?php
          }
          ?>
        </div>
      </div>
      
      <?php
      }
    }
  }
}
