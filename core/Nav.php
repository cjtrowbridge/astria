<?php
  
function Nav($Which,$Type,$Text,$Link){
  global $ASTRIA;
  if(isset($ASTRIA['nav'][$Which])){
    $ASTRIA['nav'][$Which]=array();
  }
    
  $ASTRIA['nav'][$Which][]=array(
    'type'=> $Type,
    'text'=> $Text,
    'link'=> $Link
  );
}
