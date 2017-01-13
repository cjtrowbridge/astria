<?php

function FieldMask($key, $value,$row){
  switch($key){
    case 'HookID':
      return '<a href="/architect/edit-hook/'.$value.'">'.$value.'</a>';
      break;
    case 'ViewID':
      return '<a href="/architect/edit-view/'.$value.'">'.$value.'</a>';
      break;
    case 'ViewCategoryID':
      return '<a href="/architect/view-category/'.$value.'">'.$value.'</a>';
      break;
    default:
      return $value;
  }
}
