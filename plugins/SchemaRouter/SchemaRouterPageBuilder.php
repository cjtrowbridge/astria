<?php

function SchemaRouterPageBuilder($Schema = false, $Table = false){
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
  $Data = Query("SELECT TABLE_SCHEMA,TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".Sanitize($Schema)."'");
  return var_export($Data,true);
}

function SchemaRouterPageBuilderGetTablePageContents($Schema, $Table){
  $Data = Query("SELECT TABLE_SCHEMA,TABLE_NAME,COLUMN_NAME,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".Sanitize($Schema)."' AND TABLE_NAME = '".Sanitize($Table)."'");
  return var_export($Data,true);
}
