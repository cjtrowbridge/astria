<?php

/*
  From https://secure.php.net/manual/en/function.filesize.php#120250
*/

function hFileSize($File){
  $factor = floor((strlen($bytes) - 1) / 3);
  if ($factor > 0) $sz = 'KMGT';
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
}
