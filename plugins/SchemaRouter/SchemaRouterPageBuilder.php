<?php

function SchemaRouterPageBuilder($Schema = false, $Table = false){
  
  if($Table == false){
    
    Event('SchemaRouter: Building $Schema page...');
    $Title   = $Schema;
    $Content = SchemaRouterPageBuilderGetSchemaPageContents($Schema);
    $Event = 'SchemaRouter_Schema_'.$Schema;
    
  }else{
    
    Event('SchemaRouter: Building $Table page.');
    $Title   = $Table;
    $Content = SchemaRouterPageBuilderGetTablePageContents($Schema, $Table);
    $Content = var_export($Content,true);
    $Event = 'SchemaRouter_Schema_'.$Schema.'_Table_'.$Table;
    
  }
  
  
  
  $Page = "<?php ".PHP_EOL.PHP_EOL;
  $Page .= "Hook('$Event',\"".PHP_EOL;
  $Page .= "  TemplateBootstrap4('$Title','$Event();'); ".PHP_EOL;
  $Page .= '");'.PHP_EOL.PHP_EOL;
  
  $Func  = "function ".$Event."(){".PHP_EOL.PHP_EOL;
  $Func .= "?>".PHP_EOL;
  $Func .="<h1><a href=\"/".$Schema."/";
  
  if(SchemaRoute('table')==false){
    $Func .=$Table."/";
  }
    
  $Func .="\">".$Title."</a>";
  if(
    SchemaRoute('Key')==0 &&
    SchemaRoute('Table')
  ){
    $Func .= ": New";
  }
  $Func .= "</h1>".PHP_EOL;
  $Func .="  <div class=\"card\">".PHP_EOL;
  $Func .="    <div class=\"card-block\">".PHP_EOL;
  $Func .="      <div class=\"card-text\">".PHP_EOL.PHP_EOL;
  if($Table){
    $Func .="        <?php echo SchemaRouterPageField('".$Schema."', '".$Table."',".$Content."); ?>".PHP_EOL.PHP_EOL;
  }else{
    foreach($Content as $Table){
      $Func .="        <p><a href=\"/".$Schema."/".$Table['TABLE_NAME']."\">".$Table['TABLE_NAME']."</a></p>".PHP_EOL.PHP_EOL;
    }
  }
  $Func .="      </div>".PHP_EOL;
  $Func .="    </div>".PHP_EOL;
  $Func .="  </div>".PHP_EOL;
  $Func .= "<?php".PHP_EOL;
  $Func .= "}".PHP_EOL;
  
  $Page.=$Func;
  
  if(!(is_dir('plugins/SchemaRouter/cache'))){
    mkdir('plugins/SchemaRouter/cache');
  }
  
  //file_put_contents('plugins/SchemaRouter/cache/'.$Event.'.php',$Page);
  
  eval($Func.'TemplateBootstrap4("'.$Title.'","'.$Event.'();");');
  exit;
  
}

function SchemaRouterPageBuilderGetSchemaPageContents($Schema){
  global $ASTRIA;
  //Dereference schema
  $DatabaseName = $ASTRIA['databases'][$Schema]['database'];
  
  $SQL="SELECT TABLE_SCHEMA,TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".Sanitize($DatabaseName)."'";
  $Data = Query($SQL,$Schema);
  return $Data;
  return var_export($Data,true);
}

function SchemaRouterPageBuilderGetTablePageContents($Schema, $Table){
  
  global $ASTRIA;
  //Dereference schema
  $DatabaseName = $ASTRIA['databases'][$Schema]['database'];
  
  $ColumnSQL = "SELECT TABLE_SCHEMA,TABLE_NAME,COLUMN_NAME,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".Sanitize($DatabaseName)."' AND TABLE_NAME = '".Sanitize($Table)."'";
  $ConstraintSQL = "
  
    SELECT COLUMN_NAME, CONSTRAINT_TYPE, REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME
    FROM information_schema.KEY_COLUMN_USAGE 
    LEFT JOIN information_schema.TABLE_CONSTRAINTS ON
      information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA    = information_schema.KEY_COLUMN_USAGE.TABLE_SCHEMA AND
      information_schema.TABLE_CONSTRAINTS.TABLE_NAME      = information_schema.KEY_COLUMN_USAGE.TABLE_NAME AND
      information_schema.TABLE_CONSTRAINTS.CONSTRAINT_NAME = information_schema.KEY_COLUMN_USAGE.CONSTRAINT_NAME
    WHERE 
      information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA = '".Sanitize($DatabaseName)."' AND
      information_schema.TABLE_CONSTRAINTS.TABLE_NAME   = '".Sanitize($Table)."'
  ";
  
  $Data        = Query($ColumnSQL,$Schema);
  $Constraints = Query($ConstraintSQL,$Schema);
  
  foreach($Data as &$Column){
    
    //initialize an array to hold this column's constraints
    $Column['Constraints']=array();
    
    //look through all the constraints and put them in the constraints array for each column
    foreach($Constraints as $Constraint){
      if($Column['COLUMN_NAME'] == $Constraint['COLUMN_NAME']){
        $Column['Constraints'][ $Constraint['CONSTRAINT_TYPE'] ] = $Constraint;
      }
    }
  }
  
  return var_export($Data,true);
}
