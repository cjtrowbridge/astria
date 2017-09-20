<?php

function MySQLDatabaseDescribe($Alias){
  global $ASTRIA;
  $Name = $ASTRIA['databases'][$Alias]['database'];
  $Type = $ASTRIA['databases'][$Alias]['type'];
  $Tables = Query('SHOW TABLES',$Alias);
  
  ?><h1><A href="/architect">Architect</a> / <a href="/architect/schema">Schema</a> / '<a href="/architect/schema/<?php echo $Alias; ?>/"><?php echo $Name; ?></a>'</h1>  
  
<p>
  <a class="btn btn-outline-success" href="/architect/schema/<?php echo $Alias; ?>/table/?new">New Table</a>
  <a class="btn btn-outline-success" href="/architect/schema/<?php echo $Alias; ?>/?query">Run A Query</a>
</p>

<h4>Tables:</h4>
<ul>
  
<?php
    
  foreach($Tables as $Table){
    $Table = array_shift($Table);
    echo '  <li><a href="/architect/schema/'.path(2).'/table/'.$Table.'">'.$Table.'</a></li>'.PHP_EOL;
  }
  ?>
    
</ul>

<?php
}
