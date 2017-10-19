<?php

function SchemaRouterPageField($Schema,$Table,$Fields){
  
  $Schema = Sanitize(path(0));
  $Table = Sanitize(path(1,false));
  $Key = intval(path(2));
  if($Key){
    $Table = Sanitize($Table);
    $SQL = "SELECT * FROM `".$Table."` WHERE ".$Table."ID = ".$Key;
    $Row = Query($SQL,$Schema);
  }
  
  $R  = PHP_EOL;
  foreach($Fields as $Field){
    $R .= '  <div class="row">'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-2">'.PHP_EOL;
    $R .= '      '.$Field['COLUMN_NAME'].PHP_EOL;
    $R .= '    </div>'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-10">'.PHP_EOL;
    
    switch($Field['DATA_TYPE']){
      default:
      //case 'varchar':
        if($Key){
          echo $Row[$Field['COLUMN_NAME']];
        }
        break;
    }
    
    $R .= '    </div>'.PHP_EOL;
    $R .= '  </div>'.PHP_EOL;
    $R .= '  <!--'.PHP_EOL.var_export($Field,true).PHP_EOL.'-->'.PHP_EOL.PHP_EOL;
  }
  return $R;
}
