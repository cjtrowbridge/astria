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
    $Event = 'SchemaRouter_Schema_'.$Schema.'_Table_'.$Table;
    
  }
  
  
  
  $Page = "<?php ".PHP_EOL.PHP_EOL;
  $Page .= "Hook('$Event',\"".PHP_EOL;
  $Page .= "  TemplateBootstrap4('$Title','$Event();'); ".PHP_EOL;
  $Page .= '");'.PHP_EOL.PHP_EOL;
  $Page .= "function ".$Event."(){".PHP_EOL.PHP_EOL;
  $Page .= "?>".PHP_EOL;
  
  $Page .="<h1><a href=\"\">".$Title."</a></h1>".PHP_EOL;
  $Page .="  <div class=\"card\">".PHP_EOL;
  $Page .="    <div class=\"card-block\">".PHP_EOL;
  $Page .="      <div class=\"card-text\">".PHP_EOL.PHP_EOL;
  $Page .="        <?php echo SchemaRouterPageField('".$Schema."', '".$Table."',".$Content."); ?>".PHP_EOL.PHP_EOL;
  $Page .="      </div>".PHP_EOL;
  $Page .="    </div>".PHP_EOL;
  $Page .="  </div>".PHP_EOL;
  
  $Page .= "<?php".PHP_EOL;
  $Page .= "}".PHP_EOL;
  
  if(!(is_dir('plugins/SchemaRouter/cache'))){
    mkdir('plugins/SchemaRouter/cache');
  }
  
  file_put_contents('plugins/SchemaRouter/cache/'.$Event.'.php',$Page);
  
  eval($Page);
  Event($Event);
  exit;
  
}

function SchemaRouterPageBuilderGetSchemaPageContents($Schema){
  global $ASTRIA;
  //Dereference schema
  $DatabaseName = $ASTRIA['databases'][$Schema]['database'];
  
  $SQL="SELECT TABLE_SCHEMA,TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".Sanitize($DatabaseName)."'";
  $Data = Query($SQL,$Schema);
  return var_export($Data,true);
}

function SchemaRouterPageBuilderGetTablePageContents($Schema, $Table){
  
  global $ASTRIA;
  //Dereference schema
  $DatabaseName = $ASTRIA['databases'][$Schema]['database'];
  
  $SQL="SELECT TABLE_SCHEMA,TABLE_NAME,COLUMN_NAME,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".Sanitize($DatabaseName)."' AND TABLE_NAME = '".Sanitize($Table)."'";
  $Data = Query($SQL,$Schema);
  return var_export($Data,true);
}
