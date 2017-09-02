<?php

function FeedSyncUI(){
  switch(path(1)){
    
    case false:
      include('FeedSyncHUD.php');
      FeedSyncHUD();
      break;
  }
}
