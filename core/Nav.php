<?php

global $ASTRIA;
$ASTRIA['nav']=array();

function Nav($Which,$Type,$Text,$Link){
  global $ASTRIA;
  if(isset($ASTRIA['nav'][strtolower($Which)])){
    $ASTRIA['nav'][strtolower($Which)]=array();
  }
    
  $ASTRIA['nav'][strtolower($Which)][]=array(
    'type'=> strtolower($Type),
    'text'=> $Text,
    'link'=> $Link
  );
}

function ShowNav($Which){
 if(
  isset($ASTRIA['nav'])&&
  isset($ASTRIA['nav']['main'])
){
  foreach($ASTRIA['nav']['main'] as $Nav){
    if(strtolower($Nav['type'])=='link'){
    ?>
          
      <li class="nav-item<?php if(path()==ltrim($path,"/")){ echo ' active';} ?>">
        <a class="nav-link" href="<?php echo $path; ?>"><?php echo $link; ?></a>
      </li>

      <?php
      }
    }
  }
}
