<?php

function SchemaRouterPageField($Schema,$Table,$Fields){
  $R  = '';
  foreach($Fields as $Field){
    $R .= '<p>'.var_export($Field,true).'</p>';
  }
  return $R;
}
