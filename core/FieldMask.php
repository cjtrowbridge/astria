<?php

function FieldMask($key, $value,$row){
  switch($key){
    case 'GroupID':
      return '<a href="/architect/edit-group/'.$value.'">'.$value.'</a>';
      break;
    case 'UserID':
      return '<a href="/architect/edit-user/'.$value.'">'.$value.'</a>';
      break;
    case 'CategoryID':
      return '<a href="/architect/edit-category/'.$value.'">'.$value.'</a>';
      break;
    case 'HookID':
      return '<a href="/architect/edit-hook/'.$value.'">'.$value.'</a>';
      break;
    case 'PermissionID':
      return '<a href="/architect/edit-permission/'.$value.'">'.$value.'</a>';
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
