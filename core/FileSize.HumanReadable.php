<?php

/*
  From https://secure.php.net/manual/en/function.filesize.php#120250
*/

function hFileSize($File,$Precision = 2){
  $bytes = filesize($File);
  
  $factor = floor((strlen($bytes) - 1) / 3);
  if ($factor > 0) $sz = 'KMGT';
  return sprintf("%.{$Precision}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
}
