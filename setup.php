<?php

function setup(){
  require('core/SimplePage.php');
  SimplePage('Astria Setup','setupBodyCallback();');
}

function setupBodyCallback(){
?>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>Welcome To Astria Setup</h1>
        
      </div>
    </div>
</div>

<?php
}
