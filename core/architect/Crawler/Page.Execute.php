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
  
  if(isset($_GET['execute'])){
    $Task = Query("SELECT CrawlerTaskID, CrawlerID, URL FROM CrawlerTask WHERE Data IS NULL AND CrawlerID = ".intval($CrawlerID)." AND CrawlerTaskID = ".intval($_GET['execute']));
    if(!isset($Task[0])){
      die('Task Not Found');
    }
    $Task = $Task[0];
    $Data = FetchURL($Task['URL']);
    
    $SQL = "UPDATE CrawlerTask SET Data = 'Cached To Disk' AND TimeFetched = NOW() WHERE CrawlerTaskID = '".intval($_GET['execute'])."';";
    
    writeDiskCache(md5($Task['URL']),$Data);
      
    Query($SQL);
    echo $Data;

    exit;
  }
  
  $Tasks = Query("SELECT CrawlerTaskID, CrawlerID, URL FROM CrawlerTask WHERE Data IS NULL AND CrawlerID = ".intval($CrawlerID)." ORDER BY CrawlerTaskID ASC");
  
  foreach($Tasks as $Task){
    ?>
    <p><a href="/architect/Crawler/execute/<?php echo $Task['CrawlerID']; ?>/?execute=<?php echo $Task['CrawlerTaskID']; ?>" target="_blank" onclick="setTimeout(function(){window.location.reload(1);}, 5000);">Execute Task <?php echo $Task['CrawlerTaskID']; ?>: <?php echo $Task['URL']; ?></a></p>
    <?php
  }
  
  exit;
}
