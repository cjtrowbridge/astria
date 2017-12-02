<?php

function Architect_Crawler_Homepage(){
  
  
  TemplateBootstrap4('New - Crawler - Architect','Architect_Crawler_Homepage_BodyCallback();');
}

function Architect_Crawler_Homepage_BodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/crawler">Crawler</a></h1>
  
  <?php 
    $Crawlers = Query('SELECT * FROM Crawler LEFT JOIN CrawlerDataset ON Crawler.CrawlerID = CrawlerDataset.CrawlerID');
    foreach($Crawlers as $Crawler){
      
      $Query1Value = 'plumbing';
      $Query2Value = '95603';
      
      ?>
      <div class="card">
        <div class="card-block">
          <div class="card-text">
            <h4><a href="/astria/Crawler/<?php echo $Crawler['CrawlerID']; ?>"><?php echo $Crawler['Name']; ?></a>: <a href="/astria/CrawlerDataset/<?php echo $Crawler['CrawlerDatasetID']; ?>"><?php echo $Crawler['Query1'].' '.$Crawler['Query2']; ?></a></h4>
            <p><?php echo $Crawler['Description']; ?></p>
            
            <a class="btn btn-success" target="_blank" href="<?php echo $Crawler['Protocol'].'://'.$Crawler['Domain'].'/'.$Crawler['Path'].'?'.$Crawler['QueryVariable1'].'='.$Query1Value.'&'.$Crawler['QueryVariable2'].'='.$Query2Value.'&'.$Crawler['RangeVariable'].'='.$Crawler['RangeMin']; ?>">Test First Page Link</a>
            <a class="btn btn-success" target="_blank" href="<?php echo $Crawler['Protocol'].'://'.$Crawler['Domain'].'/'.$Crawler['Path'].'?'.$Crawler['QueryVariable1'].'='.$Query1Value.'&'.$Crawler['QueryVariable2'].'='.$Query2Value.'&'.$Crawler['RangeVariable'].'='.($Crawler['RangeMax']-$Crawler['RangeMax']%$Crawler['RangeIncrement']); ?>">Test Last Page Link</a>
            <a class="btn btn-danger" href="/architect/crawler/build/<?php echo $Crawler['CrawlerID'].'/?dataset='.$Crawler['CrawlerDatasetID']; ?>">Build Task List</a>
            
          </div>
        </div>
      </div>
      <?php
    }
  
}
