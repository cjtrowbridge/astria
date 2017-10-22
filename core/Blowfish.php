<?php 

function BlowfishEncrypt($pure_string, $encryption_key=null){
  
  if($encryption_key==null){
    global $ASTRIA;
    $encryption_key=$ASTRIA['app']['encryptionKey'];
  }
  $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $encrypted_string = base64_encode(mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv));
  return $encrypted_string;
  
}

function BlowfishDecrypt($encrypted_string, $encryption_key=null){
  
  if($encryption_key==null){
    global $ASTRIA;
    $encryption_key=$ASTRIA['app']['encryptionKey'];
  }
  $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
  $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, base64_decode($encrypted_string), MCRYPT_MODE_ECB, $iv);
  
  //Make sure it's UTF8 now
  $decrypted_string = UTF8($decrypted_string);
  
  return $decrypted_string;
  
}
