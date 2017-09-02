<?php

function FeedSyncUI(){
  switch(path(2)){
    
    case false:
      include('FeedSyncHUD.php');
      FeedSyncHUD();
      break;
  }
}
