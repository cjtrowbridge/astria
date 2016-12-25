<?php

function setup(){
  require('core/SimplePage.php');
  SimplePage('Astria Setup','setupBodyCallback();');
}

function setupBodyCallback(){
?><h1>Welcome To Astria Setup</h1>

<?php
}
