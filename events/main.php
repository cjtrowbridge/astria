<?php

global $EVENTS, $DEBUG;

$EVENTS=array();
$DEBUG=array(
  0=>array(
    'debug point'=> 'Startup',
    'memory usage'=> (memory_get_usage()/1000000),
    'runtime'=>0,
    'time'=> round(microtime(true),4)
  )
);

require('Hook.php');
require('Event.php');
require('DebugShowSummary.php');
