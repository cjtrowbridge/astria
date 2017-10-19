<?php

function SchemaRouterPageField($Schema,$Table,$Fields){
  if(!(is_array($Fields))){
    eval('$Fields = '.$Fields.';');
  }
  
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
  
  foreach($Fields as $Field){
    
    $Value='';
    if($Key){
      $Value = $Row[$Field['COLUMN_NAME']];
    }
    
    $R .= '  <div class="row">'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-2">'.PHP_EOL;
    $R .= '      '.$Field['COLUMN_NAME'].PHP_EOL;
    $R .= '    </div>'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-10">'.PHP_EOL;
    
    
    if(false){
      //is foreign key
      //do a dropdown
      
      
    }else{
    
      switch($Field['DATA_TYPE']){
        default:
        case 'varchar':
          if($Key){
            echo '      <input type="text" name="'.$Field['COLUMN_NAME'].'" value="'.$Value.'" class="form-control">'.PHP_EOL;
          }
          break;
      }
      
    }
    
    $R .= '    </div>'.PHP_EOL;
    $R .= '  </div><br>'.PHP_EOL;
    $R .= '  <!--'.PHP_EOL.var_export($Field,true).PHP_EOL.'-->'.PHP_EOL.PHP_EOL;
  }
  return $R;
}
