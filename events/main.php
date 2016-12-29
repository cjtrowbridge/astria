<?php

global $EVENTS, $DEBUG;

$EVENTS=array();
$DEBUG=array(
  0=>array(
    'description'=> 'Startup',
    'ram'=> (memory_get_usage()/1000000),
    'runtime'=>0,
    'timestamp'=> round(microtime(true),4)
  )
);

include('Hook.php');
include('Event.php');
include('DebugShowSummary.php');
