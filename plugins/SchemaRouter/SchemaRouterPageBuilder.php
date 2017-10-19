<?php

function SchemaRouterPageBuilder($Schema = false, $Table = false){
  global $ASTRIA;
  //Dereference schema
  $Schema = $ASTRIA['databases'][$Schema]['database'];
  
  if($Table == false){
    
    Event('SchemaRouter: Building $Schema page...');
    $Title   = $Schema;
    $Content = SchemaRouterPageBuilderGetSchemaPageContents($Schema);
    $Event = 'SchemaRouter: View_Schema_'.$Schema;
    
  }else{
    
    Event('SchemaRouter: Building $Table page.');
    $Title   = $Table;
    $Content = SchemaRouterPageBuilderGetTablePageContents($Schema, $Table);
    $Event = 'SchemaRouter: View_Schema_'.$Schema.'_View_Table_'.$Table;
    
  }
  
  $Page = PHP_EOL."<h1><a href=\"\">".$Title."</a></h1>".PHP_EOL;
  $Page .="  <div class=\"card\">".PHP_EOL;
  $Page .="    <div class=\"card-block\">".PHP_EOL;
  $Page .="      <div class=\"card-text\">".PHP_EOL.PHP_EOL;
  $Page .="        <?php echo SchemaRouterPageField('".$Schema."', '".$Table."',array(".$Content.")); ?>".PHP_EOL.PHP_EOL;
  $Page .="      </div>".PHP_EOL;
  $Page .="    </div>".PHP_EOL;
  $Page .="  </div>".PHP_EOL;
  
  die($Page);
  
}

function SchemaRouterPageBuilderGetSchemaPageContents($Schema){
  $SQL="SELECT TABLE_SCHEMA,TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".Sanitize($Schema)."'";
  $Data = Query($SQL,$Schema);
  pd($SQL);
  pd($Data);
  return var_export($Data,true);
}

function SchemaRouterPageBuilderGetTablePageContents($Schema, $Table){
  $SQL="SELECT TABLE_SCHEMA,TABLE_NAME,COLUMN_NAME,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".Sanitize($Schema)."' AND TABLE_NAME = '".Sanitize($Table)."'";
  $Data = Query($SQL,$Schema);
  pd($SQL);
  pd($Data);
  return var_export($Data,true);
}
