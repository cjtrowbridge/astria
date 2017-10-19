<?php

function SchemaRouterPageField($Schema,$Table,$Fields){
  $R  = PHP_EOL;
  foreach($Fields as $Field){
    $R .= '  <div class="row">'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-2">'.PHP_EOL;
    $R .= '      '$Field['COLUMN_NAME'].PHP_EOL;
    $R .= '    </div>'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-10">'.PHP_EOL;
    $R .= '      '$Field['DATA_TYPE'].PHP_EOL;
    $R .= '    </div>'.PHP_EOL;
    $R .= '  </div>'.PHP_EOL;


//    '.var_export($Field,true).'</p>';

  }
  return $R;
}
