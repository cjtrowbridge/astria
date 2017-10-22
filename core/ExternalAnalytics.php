<?php

//This should always run regardless of the state or route. It will only do anything if appropriate and it never outputs anything.
ExternalAnalytics();

function ExternalAnalytics(){
  global $ASTRIA;
  if(isset($ASTRIA['analytics'])){
  
    if(isset($ASTRIA['analytics']['Google'])){
      Hook('Template Head','GoogleAnalyticsSnippet();');
    }else{
      Hook('Architect Homepage','AlertAdminMissingAnalytics();');
    }
    
    
  
  }else{
    Hook('Architect Homepage','AlertAdminMissingAnalytics();');
  }
}

function GoogleAnalyticsSnippet(){
  global $ASTRIA;
  echo PHP_EOL.$ASTRIA['analytics']['Google'].PHP_EOL;
}


function AlertAdminMissingAnalytics(){
  ?>
    <div class="card">
      <div class="card-block">
        <h4 class="card-title">Missing Analytics Configuration</h4>
        <p class="card-text"><a href="/architect/configuration" class="card-link">Click Here</a> to update missing configuration data.</p>
      </div>
    </div>
  <?php
}
