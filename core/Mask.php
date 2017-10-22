<?php

function InputMask($Key, $Value,$Row = false,$Class = ''){
  switch($Key){
    case 'Code':
      return '    <textarea name="'.$Key.'" id="'.$Key.'" class="'.$Class.'">'.$Value.'</textarea>'."\n";
    case 'Astria Event':
      $Return = "    <select name=\"".$Key."\" id=\"".$Key."\" class=\"".$Class."\">\n";
      $Return.= "      <option value=\"User Is Logged In\">User Is Logged In</option>\n";
      $Return.= "      <option value=\"User Is Logged In - Before Presentation\">User Is Logged In - Before Presentation</option>\n";
      $Return.= "      <option selected value=\"User Is Logged In - Presentation\">User Is Logged In - Presentation</option>\n";
      $Return.= "      <option value=\"Template Body\">Template Body</option>\n";
      $Return.= "      <option value=\"User Is Logged In - No Presentation\">User Is Logged In - No Presentation</option>\n";
      $Return.= "      <option value=\"User Is Not Logged In\">User Is Not Logged In</option>\n";
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
