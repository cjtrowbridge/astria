<?php

function Architect_Crawler_Execute(){
  $CrawlerID = intval(path(3));
  if($CrawlerID == false){
    die('Invalid Crawler ID');
  }
  
  $Crawler = Query('SELECT * FROM Crawler WHERE CrawlerID = '.$CrawlerID);
  if(!(isset($Crawler[0]))){
    die('Crawler Not Found');
  }
  $Crawler=$Crawler[0];
  
  $Tasks = Query("SELECT CrawlerTaskID, URL FROM CrawlerTask WHERE Data IS NULL AND CrawlerID = ".intval($CrawlerID)." ORDER BY CrawlerTaskID ASC");
  
  foreach($Tasks as $Task){
    ?>
    <p><a href="/architect/Crawler/execute/<?php echo $Task['CrawlerID']; ?>/?execute=<?php echo $Task['CrawlerTaskID']; ?>">Execute Task <?php echo $Task['CrawlerTaskID']; ?>: <?php echo $Task['URL']; ?></a></p>
    <?php
  }
  
  exit;
}
