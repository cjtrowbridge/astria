<?php


define('CACHE_FILE_PREFIX','<?php /* ');
define('CACHE_FILE_SUFFIX',' */ header("HTTP/1.1 301 Moved Permanently");header("Location: /");');
define('CACHE_FILE_TTL',60*60*24*7);

function ReadCache($Hash,$TTL){
  include_once('DiskCache.php');
  return readDiskCache($Hash,$TTL);
}

function WriteCache($Hash,$Value){
  include_once('DiskCache.php');
  return writeDiskCache($Hash,$Value);
}

function DeleteCache($Hash){
  include_once('DiskCache.php');
  return deleteDiskCache($Hash);
}

