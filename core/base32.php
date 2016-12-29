<?php

function base32_encode($data){
  $CHARS = '0123456789abcdefghijklmnopqrstuv';
  $dataSize = strlen($data);
  $res = '';
  $remainder = 0;
  $remainderSize = 0;

  for ($i = 0; $i < $dataSize; $i++)
  {
    $b = ord($data[$i]);
    $remainder = ($remainder << 8) | $b;
    $remainderSize += 8;
    while ($remainderSize > 4)
    {
      $remainderSize -= 5;
      $c = $remainder & (31 << $remainderSize);
      $c >>= $remainderSize;
      $res .= $CHARS[$c];
    }
  }
  if ($remainderSize > 0)
  {
    // remainderSize < 5:
    $remainder <<= (5 - $remainderSize);
    $c = $remainder & 31;
    $res .= $CHARS[$c];
  }

  return $res;
}
	
function base32_decode($data){
  $CHARS = '0123456789abcdefghijklmnopqrstuv';
  $data = strtolower($data);
  $dataSize = strlen($data);
  $buf = 0;
  $bufSize = 0;
  $res = '';

  for ($i = 0; $i < $dataSize; $i++)
  {
    $c = $data[$i];
    $b = strpos($CHARS, $c);
    if ($b === false)
      die('Encoded string is invalid, it contains unknown char #'.ord($c));
    $buf = ($buf << 5) | $b;
    $bufSize += 5;
    if ($bufSize > 7)
    {
      $bufSize -= 8;
      $b = ($buf & (0xff << $bufSize)) >> $bufSize;
      $res .= chr($b);
    }
  }

  return $res;
}
