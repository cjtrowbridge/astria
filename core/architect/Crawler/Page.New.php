<?php

function Architect_Crawler_New(){
  
  
  TemplateBootstrap4('New - Crawler - Architect','Architect_Crawler_New_BodyCallback();');
}

function Architect_Crawler_New_BodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/crawler">Crawler</a> / <a href="/architect/crawler/new">New</a></h1>
  <form action="" class="form" method="post">
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group">
          <label for="inputURL">URL</label>
          <input type="text" class="form-control" name="inputURL" id="inputURL" aria-describedby="inputURLHelp" placeholder="Enter URL" <?php if(isset($_POST['inputURL'])){echo ' value="'.$_POST['inputURL'].'"';} ?>>
          <small id="inputURLHelp" class="form-text text-muted">This is the URL for one example page containing the variable. For example, the first search result page.</small>
        </div>
      </div>
      <?php
        
        if(isset($_POST['inputURL'])){
      ?>
      <div class="col-xs-12">
        <div class="card">
          <div class="card-block">
            <div class="card-text">
              <h4>URL Dissection:</h4>
              <?php
                $URL = parse_url($_POST['inputURL']);
                pd($URL);
                parse_str($URL['query'],$Arguments);
                pd($Arguments);
                
              ?>
            </div>
          </div>
        </div>
      </div>
      <?php
        }
        
      ?>
      <div class="col-xs-12">
        <div class="form-group">
         <input type="submit" class="btn btn-success" value="Next">
        </div>
      </div>
    </div>
  </form>
  <?php
}
