<?php

function RepoTracker_Homepage(){
  TemplateBootstrap4('RepoTracker','RepoTracker_Homepage_BodyCallback();');
}

function RepoTracker_Homepage_BodyCallback(){
  ?><h1>ReopTracker</h1>
  show a list of all repositories found locally.
  <?php
}
