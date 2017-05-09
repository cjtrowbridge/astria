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
     }
   }
 }
