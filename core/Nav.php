<?php
  
function Nav($Which,$Type,$Text,$Link){
  global $ASTRIA;
  if(isset($ASTRIA['nav'][$Which])){
    $ASTRIA['nav'][$Which]=array();
  }
    
  $ASTRIA['nav'][strtolower($Which)][]=array(
    'type'=> strtolower($Type),
    'text'=> $Text,
    'link'=> $Link
  );
}
