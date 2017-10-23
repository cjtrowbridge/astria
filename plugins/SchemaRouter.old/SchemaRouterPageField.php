<?php

function SchemaRouterPageField($Schema,$Table,$Fields){
  
  //depending on hwo this is called, this might be an exported array. if so, convert it to a real array
  if(!(is_array($Fields))){
    eval('$Fields = '.$Fields.';');
  }
  
  //get the details about where we are. This should later be abstracted
  $Schema = SchemaRoute('Schema');
  $Table  = SchemaRoute('Table');
  $Key    = SchemaRoute('Key');
  
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
  
  $R  = PHP_EOL; //Iniitalize output variable
  
  foreach($Fields as $Field){
    
    if(
      $Key==0 && 
      isset($Field['Constraints']['PRIMARY KEY'])
    ){
      continue;
    }
    
    $Value='';
    if($Key){
      $Value = $Row[$Field['COLUMN_NAME']];
    }
    
    $R .= '  <div class="row">'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-2">'.PHP_EOL;
    $R .= '      '.$Field['COLUMN_NAME'].PHP_EOL;
    $R .= '    </div>'.PHP_EOL;
    $R .= '    <div class="col-xs-12 col-lg-10">'.PHP_EOL;
    
    
    if(count($Field['Constraints'])>0){
      foreach($Field['Constraints'] as $Constraint){
        switch($Constraint['CONSTRAINT_TYPE']){
          case 'PRIMARY KEY':
            $R.='<input type="hidden" name="'.$Field['COLUMN_NAME'].'" value="'.$Value.'"><a href="/'.$Schema.'/'.$Table.'/'.$Value.'">'.$Value.'</a>'; //TODO make this link to the text from the first varchar in that table
            break;
          case 'FOREIGN KEY':
            //$R.='<p>DO A DROPDOWN FOR FOREIGN KEY '.$Constraint['REFERENCED_COLUMN_NAME'].' IN TABLE '.$Constraint['REFERENCED_TABLE_NAME'].'</p>';
            $R.='<a href="/'.$Schema.'/'.$Constraint['REFERENCED_TABLE_NAME'].'/'.$Value.'">'.$Value.'</a>';  //TODO make this link to the text from the first varchar in that table
            break;
          default:
            $R .= ShowField($Field,$Value);
            break;
        }
        
                
      }
    }else{
    
      $R .= ShowField($Field,$Value);
      
    }
    
    
    
    $R .= '    </div>'.PHP_EOL;
    $R .= '  </div><br>'.PHP_EOL;
    $R .= '  <!--'.PHP_EOL.var_export($Field,true).PHP_EOL.'-->'.PHP_EOL.PHP_EOL;
  }
  
    $R .= '  <div class="row">'.PHP_EOL;
    $R .= '    <div class="col-xs-12">'.PHP_EOL;
    $R .= '      <input type="submit" class="btn btn-block btn-success" value="Save">'.PHP_EOL;
    $R .= '    </div>'.PHP_EOL;
    $R .= '  </div>'.PHP_EOL;
  return $R;
}

function ShowField($Field,$Value){
  $R = '';
  
  if(
    $Field['COLUMN_NAME']=='UserInserted'||
    $Field['COLUMN_NAME']=='TimeInserted'||
    $Field['COLUMN_NAME']=='UserUpdated'||
    $Field['COLUMN_NAME']=='TimeUpdated'
  ){
    return '      '.$Value.PHP_EOL;
  }
  
  switch($Field['DATA_TYPE']){
    default:
    case 'varchar':
      $R.='      <input type="text" name="'.$Field['COLUMN_NAME'].'" value="'.$Value.'" class="form-control">'.PHP_EOL;
      break;
  }
  return $R;
}