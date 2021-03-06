<?php

//TODO be able to see the content of done stuff

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
  
  
  if(isset($_GET['show'])){

    $Path = 'cache/Crawler/'.intval($_GET['show']).'.html';
    
    if(!(file_exists($Path))){
      die('File Not Found.');
    }
    
    $Data = file_get_contents($Path);
    
    echo $Data;
    exit;
  }
  
  if(isset($_GET['execute'])){
    $Task = Query("SELECT CrawlerTaskID, CrawlerID, URL FROM CrawlerTask WHERE Message IS NULL AND CrawlerID = ".intval($CrawlerID)." AND CrawlerTaskID = ".intval($_GET['execute']));
    if(!isset($Task[0])){
      die('Task Not Found');
    }
    $Task = $Task[0];
    $Data = FetchURL($Task['URL']);
    
    $SQL = "UPDATE CrawlerTask SET Message = 'Cached To Disk', TimeFetched = NOW() WHERE CrawlerTaskID = '".intval($_GET['execute'])."';";
    
    $Hash = md5(intval($_GET['execute']).'_'.$Task['URL']);
    if(is_dir('cache')){
      if(!is_dir('cache/Crawler')){
        mkdir('cache/Crawler');
      }
      file_put_contents('cache/Crawler/'.intval($_GET['execute']).'.html',$Data);
    }else{
      die("Can't Find Cache Dir");
    }
    
    Query($SQL);
    header('Location: ./?show='.intval($_GET['execute']));
    exit;
  }
  
  TemplateBootstrap4('Execute Crawls','Architect_Crawler_Execute_BodyCallback();');
}
  
function Architect_Crawler_Execute_BodyCallback(){
  $CrawlerID = intval(path(3));
  
  echo '<h1>Todo</h1><div id="todo">';
  $Tasks = Query("SELECT CrawlerTaskID, CrawlerID, URL FROM CrawlerTask WHERE Message IS NULL AND CrawlerID = ".intval($CrawlerID)." ORDER BY CrawlerTaskID ASC");
  foreach($Tasks as $Task){
    $URL = '/architect/Crawler/execute/'.$Task['CrawlerID'].'/?execute='.$Task['CrawlerTaskID'];
    ?>
    <p><a href="javascript:void(0);" data-uri="<?php echo $URL; ?>" target="_blank">Execute Task <?php echo $Task['CrawlerTaskID']; ?>: <?php echo $Task['URL']; ?></a></p>
    <?php
  }
  
  echo '</div><hr><h1>Done</h1>';
  $Tasks = Query("SELECT CrawlerTaskID, CrawlerID, URL FROM CrawlerTask WHERE Message IS NOT NULL AND CrawlerID = ".intval($CrawlerID)." ORDER BY CrawlerTaskID ASC");
  foreach($Tasks as $Task){
    ?>
    <p><a href="/architect/Crawler/execute/<?php echo $Task['CrawlerID']; ?>/?show=<?php echo $Task['CrawlerTaskID']; ?>" target="_blank">Execute Task <?php echo $Task['CrawlerTaskID']; ?>: <?php echo $Task['URL']; ?></a></p>
    <?php
  }
  ?>

  <script>
    $("#todo a").click(function(event){
      event.preventDefault();
      $.get( $(this).data('uri') , function(data){
        //var timer = Math.random() * (5000 - 1000) + 1000;
      //setTimeout($("#todo a:first-of-type").click(),timer);
      });
      $(this).remove();
      
    });
    $("#todo a:first-of-type").click();
  </script>
  <?php
  exit;
}
