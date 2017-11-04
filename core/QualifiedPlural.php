<?php

function QualifiedPlural($String){
  $String = rtrim($String,'s');
  $String .= "(s)";
  return $String;
}
