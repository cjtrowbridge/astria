<?php


define('CACHE_FILE_PREFIX','<?php /* ');
define('CACHE_FILE_SUFFIX',' */ header("HTTP/1.1 301 Moved Permanently");header("Location: /");');
define('CACHE_FILE_TTL',60*60*24*7);
define('CACHE_DATABASE_TTL',60*60*24*7);

function ReadCache($Hash,$TTL=0){
  //include_once('DiskCache.php');
  //return readDiskCache($Hash,$TTL);
  include_once('CacheDatabase.php');
  return CacheDatabaseRead($Hash,$TTL);
}

function WriteCache($Hash,$Value){
  //include_once('DiskCache.php');
  //return writeDiskCache($Hash,$Value);
  include_once('CacheDatabase.php');
  return CacheDatabaseWrite($Hash,$Value);
}

function DeleteCache($Hash){
  //include_once('DiskCache.php');
  //return deleteDiskCache($Hash);
  include_once('CacheDatabase.php');
  return CacheDatabaseDelete($Hash);
}

