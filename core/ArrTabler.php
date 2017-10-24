<?php

function ArrTabler($arr, $table_class = 'table tablesorter tablesorter-ice tablesorter-bootstrap', $table_id = null,$Sort = true,$OutputCallback = false){
  $return='';
  if($table_id==null){
    $table_id=md5(uniqid(true));
  }
  if(count($arr)>0){
    $return.="\n<div class=\"table-responsive\">\n";
    $return.= "\r\n".'	<table id="'.$table_id.'" class=" table'.$table_class.'">'."\n";
    $first=true;
    foreach($arr as $row){
      if($first){
        $return.= "		<thead>\n";
        $return.= "			<tr>\n";
        foreach($row as $key => $value){
          $return.= "				<th>".ucwords($key)."</th>\n";
        }
        $return.= "			</tr>\n";
        $return.= "		</thead>\n";
        $return.= "		<tbody>\n";
      }
      $first=false;
      $return.= "			<tr>\n";
      foreach($row as $key => $value){
        if($OutputCallback == false){
          $return.="<td>".$value."</td>";  
        }else{
          //TODO i dont think this will work like this but i dont need it to work at this point
          $return.="<td>".$OutputCallback($key, $value,$row)."</td>";
        }
        
      }
      $return.= "			</tr>\n";
    }
    $return.= "		</tbody>\n";
    $return.= "	</table>\n";
    $return.= "</div>\n";
    if($Sort){
      $return.= "<script>$('#".$table_id."').tablesorter({widgets: ['zebra', 'filter']});</script>\n";
    }else{
      $return.= "<script>$('#".$table_id."').tablesorter({widgets: ['zebra']});</script>\n";
    }
  }else{
    $return.="No Results Found.";
  }
  return $return;
}
