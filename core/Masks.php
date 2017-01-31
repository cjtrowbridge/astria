<?php

function InputMask($Key, $Value,$Row = false,$Class = ''){
 switch($Key){
   case 'Code':
     return '<textarea name="'.$Key.'" id="'.$Key.'" class="'.$Class.'">'.$Value.'</teaxtarea>';
     break;
   default:
     return $Value;
     break;
 }
}
  
function OutputMask($Key, $value,$row = false,$Class = ''){
  switch($Key){
    case 'GroupID':
      return '<a href="/architect/edit-group/'.$Value.'">'.$Value.'</a>';
      break;
    case 'UserID':
      return '<a href="/architect/edit-user/'.$Value.'">'.$Value.'</a>';
      break;
    case 'CategoryID':
      return '<a href="/architect/edit-category/'.$Value.'">'.$Value.'</a>';
      break;
    case 'HookID':
      return '<a href="/architect/edit-hook/'.$Value.'">'.$Value.'</a>';
      break;
    case 'PermissionID':
      return '<a href="/architect/edit-permission/'.$Value.'">'.$Value.'</a>';
      break;
    case 'ViewID':
      return '<a href="/architect/edit-view/'.$Value.'">'.$Value.'</a>';
      break;
    case 'ViewCategoryID':
      return '<a href="/architect/view-category/'.$Value.'">'.$Value.'</a>';
      break;
    default:
      return $Value;
  }
}
