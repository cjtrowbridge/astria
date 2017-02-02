<?php

function ReadCache($Hash,$TTL){
  include_once('DiskCache.php');
  return readDiskCache($Hash,$TTL);
}

function WriteCache($Hash,$Value){
  include_once('DiskCache.php');
  return writeDiskCache($Hash,$Value);
}
