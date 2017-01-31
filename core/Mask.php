<?php

function InputMask($Key, $Value,$Row = false,$Class = ''){
  switch($Key){
    case 'Code':
      return '    <textarea name="'.$Key.'" id="'.$Key.'" class="'.$Class.'">'.$Value.'</textarea>'."\n";
    case 'Astria Event':
      $Return = "    <select name=\"".$Key."\" id=\"".$Key."\" class=\"".$Class."\">\n";
      global $EVENTS;
      foreach($EVENTS as $Event => $List){
        $Return.= "      <option value=\"".$Event."\">".$Event."</option>\n";
      }
      $Return.= "    </select>\n";
      return $Return;
    default:
      return "    <input class=\"".$Class."\" type=\"text\" name=\"".$Key."\" id=\"".$Key."\" value=\"".$Value."\">\n";
      break;
  }
}
  
function OutputMask($Key, $Value,$Row = false,$Class = ''){
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
