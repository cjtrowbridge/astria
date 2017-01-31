<?php

function AstriaBootstrapAutoForm($Editable,$Readable = array(),$Hidden = array(),$Action = '/', $Method = 'post'){
  
  $Return="\n\n<!--\nAstria Bootstrap AutoForm v1.0\n\nInput:\n".var_export($Array,true)."\n\n-->\n\n";
  $Return .= "<form action=\"".$Action."\" method=\"".$Method."\">\n";
  foreach($Editable as $Key => $Value){
    $Return .= "<div class=\"form-group row\">\n";
    $Return .= "  <label class=\"col-xs-2 col-form-label\">".$Key.":</label>\n";
    $Return .= "  <div class=\"col-xs-10\">\n";
    $Return .= "    <input class=\"form-control astriaBootstrapFormInput\" type=\"text\" name=\"".$Key."\" id=\"".$Key."\" value=\"".$Value."\">\n";
    $Return .= "  </div>\n";
    $Return .= "</div>\n";
  }
  foreach($Readable as $Key => $Value){
    $Return .= "<div class=\"form-group row\">\n";
    $Return .= "  <label class=\"col-xs-2 col-form-label\">".$Key.":</label>\n";
    $Return .= "  <div class=\"col-xs-10\">\n";
    $Return .= "    ".$Value."\n";
    $Return .= "  </div>\n";
    $Return .= "</div>\n";
  }
  foreach($Hidden as $Key => $Value){
    $Return .= "    <input type=\"hidden\" name=\"".$Key."\" id=\"".$Key."\" value=\"".$Value."\">\n";
  }
  $Return .= "  <input class=\"form-control\" type=\"submit\">\n";
  $Return .= "  <script>\n";
  $Return .= "    $('.astriaBootstrapFormInput:first-of-type').focus();\n";
  $Return .= "  </script>\n";
  $Return .= "</form>\n\n";
  
  return $Return;
}
