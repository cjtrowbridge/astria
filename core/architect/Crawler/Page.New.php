<?php

function Architect_Crawler_New(){
  if(isset($_POST['inputURL'])){
    pd($_POST);
    exit;
  }
  
  TemplateBootstrap4('New - Crawler - Architect','Architect_Crawler_New_BodyCallback();');
}

function Architect_Crawler_New_BodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/crawler">Crawler</a> / <a href="/architect/crawler/new">New</a></h1>
  <form action="" class="form" method="post">
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group">
          <label for="inputURL">URL</label>
          <input type="text" class="form-control" name="inputURL" id="inputURL" aria-describedby="inputURLHelp" placeholder="Enter URL">
          <small id="inputURLHelp" class="form-text text-muted">This is the URL for one example page containing the variable. For example, the first search result page.</small>
        </div>
      </div>
    </div>
  </form>
  <?php
}
