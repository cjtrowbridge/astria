<?php

global $ASTRIA;

$ASTRIA = array(

  'app' => array(
    
    'defaultSessionLength'       => 60*60*24*7,
    'encryptionKey'              => '',
    'appName'                    => '',
    'appURL'                     => '',
    'favicon'                    => ''
    
  ),
  
  'debugging' => array(
    
    'showErrors'                 => true,
    'verbose'                    => true
    
  ),
  
  'smtp' => array(
    
    'username'                   => '',
    'password'                   => '',
    'port'                       => 25,
    'host'                       => 'localhost',
    'adminEmail'                 => '',
    'defaultEmailSubject'        => '',
    'defaultEmailFrom'           => '',
    'PHPMailerDebuggingFlag'     => 2
    /*
      0 = off (for production use)
      1 = client messages
      2 = client and server messages      
    */
    
  ),
  
  'databases'=array(
    'astria' => array(
      
      'type'                     => 'mysql',
      'hostname'                 => 'localhost',
      'username'                 => '',
      'password'                 => '',
      'database'                 => '',
      'resource'                 => false
      
    )
  ),
  
  'oauth'=array(
    
    'Google' => array(
    
      'GoogleOAuth2ClientID'     => '',
      'GoogleOAuth2ClientSecret' => ''
      
    ),
    'Facebook' => array(
    
      'FacebookOAuth2AppID'     => '',
      'FacebookOAuth2AppSecret' => ''
      
    )
    
  ),
  'locale'=>array(
    'timezone' => 'America/Los Angeles'
  )
  
);
