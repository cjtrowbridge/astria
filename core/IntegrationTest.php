<?php

Hook('Webhook','IntegrationTest();');

function IntegrationTest(){
  if(path(0)=='test'){
    switch(path(1)){
      case 'integration':
        die('ok');
      case false:
        die('Specify a test to run.');
    }
  }
}
