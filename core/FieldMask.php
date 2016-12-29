<?php

function FieldMask($key, $value,$row){
  switch($key){
    case 'ViewID':
      return '<a href="/architect/edit-view/'.$value.'">'.$value.'</a>';
      break;
    default:
      return $value;
  }
}
