<?php

function SchemaRouterPageField($Schema,$Table,$Fields){
  
  $Schema = Sanitize(path(0));
  $Table = Sanitize(path(1,false));
  $Key = intval(path(2));
  if($Key){
    $Table = Sanitize($Table);
    $SQL = "SELECT * FROM `".$Table."` WHERE ".$Table."ID = ".$Key;
    $Row = Query($SQL,$Schema);
    if(!(isset($Row[0]))){
      $Key=0;
    }else{
      $Row=$Row[0];
    }
  }
  
  $R  = PHP_EOL;
  pd($Fields);
  
  $Columns = $Fields['Columns'];
  
  foreach($Columns as $Column){
    
    $Value='';
    if($Key){
      $Value = $Row[$Column['COLUMN_NAME']];
    }
    
    $R .= '  <div class="row">'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-2">'.PHP_EOL;
    $R .= '      '.$Column['COLUMN_NAME'].PHP_EOL;
    $R .= '    </div>'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-10">'.PHP_EOL;
    
    
    if(false){
      //is foreign key
      //do a dropdown
      
      
    }else{
    
      switch($Column['DATA_TYPE']){
        default:
        case 'varchar':
          if($Key){
            echo '      <input type="text" name="'.$Column['COLUMN_NAME'].'" value="'.$Value.'" class="form-control">'.PHP_EOL;
          }
          break;
      }
      
    }
    
    $R .= '    </div>'.PHP_EOL;
    $R .= '  </div><br>'.PHP_EOL;
    $R .= '  <!--'.PHP_EOL.var_export($Column,true).PHP_EOL.'-->'.PHP_EOL.PHP_EOL;
  }
  return $R;
}
