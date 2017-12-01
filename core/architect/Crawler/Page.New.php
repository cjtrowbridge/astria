<?php

function Architect_Crawler_New(){
  /*if(
    isset($_POST['Architect_Crawler_URL']) &&
    isset($_POST['step2'])
  ){
    $Variables
    Query("
      INSERT INTO Crawler(
        `Protocol`,`Domain`,`Path`,`Query`
      )VALUES(
        '".Sanitize($_POST['Protocol'])."','".Sanitize($_POST['Domain'])."','".Sanitize($_POST['Path'])."','".Sanitize($_POST['Query'])."'
      )
    ");
    exit;
  }*/
  TemplateBootstrap4('New - Crawler - Architect','Architect_Crawler_New_BodyCallback();');
}

function Architect_Crawler_New_BodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/crawler">Crawler</a> / <a href="/architect/crawler/new">New</a></h1>
  <form action="" class="form" method="post">
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group">
          <label for="inputURL">URL</label>
          <input type="text" class="form-control" name="Architect_Crawler_URL" id="Architect_Crawler_URL" aria-describedby="inputURLHelp" placeholder="Enter URL" <?php if(isset($_POST['Architect_Crawler_URL'])){echo ' value="'.$_POST['Architect_Crawler_URL'].'"';} ?>>
          <small id="inputURLHelp" class="form-text text-muted">This is the URL for one example page containing the variable. For example, the first search result page.</small>
        </div>
      </div>
      <?php
        
        if(isset($_POST['Architect_Crawler_URL'])){
      ?>
      <input type="hidden" name="step2" value="step2">
      <div class="col-xs-12">
        <div class="card">
          <div class="card-block">
            <div class="card-text">
              <h4>Select Which Arguments Will Be Variables:</h4>
              <?php
                $URL = parse_url($_POST['Architect_Crawler_URL']);
                pd($URL);
                echo '<input type="hidden" name="Architect_Crawler_Protocol" value="'.$URL['scheme'].'">';
                echo '<input type="hidden" name="Architect_Crawler_Domain" value="'.$URL['host'].'">';
                echo '<input type="hidden" name="Architect_Crawler_Path" value="'.$URL['path'].'">';
                echo '<input type="hidden" name="Architect_Crawler_Query" value="'.$URL['query'].'">';
          
                parse_str($URL['query'],$Arguments);
                foreach($Arguments as $Key => $Value){
                  ?>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" checked="checked" class="form-check-input" name="Architect_Crawler_Variables[]" value="<?php echo $Key; ?>">
                      <input type="hidden" name="Architect_Crawler_Variables_<?php echo $Key; ?>" value="<?php echo $Value; ?>">
                      &quot;<?php echo $Key; ?>&quot;-&gt;&quot;<?php echo $Value; ?>&quot;
                    </label>
                  </div>
                  <?php
                }
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
