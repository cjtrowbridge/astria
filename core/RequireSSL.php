<?php 

function RequireSSL(){
  if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on'){
    header("Status: 301 Moved Permanently");
    header(sprintf('Location: https://%s%s',$_SERVER['HTTP_HOST'],$_SERVER['REQUEST_URI']));
    exit();
  }
}
