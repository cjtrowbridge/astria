<?php

/*
  Copied from: https://stackoverflow.com/questions/7979567/php-convert-any-string-to-utf-8-without-knowing-the-original-character-set-or
*/

function UTF8($Input){
  return iconv(mb_detect_encoding($Input, mb_detect_order(), true), "UTF-8", $Input);
}
