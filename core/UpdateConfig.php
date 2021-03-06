<?php

function UpdateConfig(
  $defaultSessionLength,
  $encryptionKey,
  $appName,
  $appURL,
  $favicon,
  $showErrors,
  $verbose,
  $smtpUsername,
  $smtpPassword,
  $smtpPort,
  $smtpHost,
  $smtpAdminEmail,
  $smtpDefaultFrom,
  $PHPMailerDebuggingFlag,
  $dbType,
  $dbHost,
  $dbUsername,
  $dbPassword,
  $dbName,
  $GoogleOAuth2ClientID,
  $GoogleOAuth2ClientSecret,
  $FacebookOAuth2AppID,
  $FacebookOAuth2AppSecret,
  $timezone,
  $googleAnalytics = '',
  $Exit = true
){
  //TODO add a null default to each argument, and then fill any nulls in with current values, then sort the arguments in order of how frequently they may ned to be updated
  
  //As far as validation goes, anyone using this function is obviously assumed to be a trusted user. Validation here seems like a moot point, but apostrophes still need to be escaped or the array wont work. Obviously if there is an apostrophe in a hostname, we have other problems, but we can deal with validating later.
  $defaultSessionLength      = str_replace("'","\'",$defaultSessionLength);
  $encryptionKey             = str_replace("'","\'",$encryptionKey);
  $appName                   = str_replace("'","\'",$appName);
  $appURL                    = str_replace("'","\'",$appURL);
  $favicon                   = str_replace("'","\'",$favicon);
  $smtpUsername              = str_replace("'","\'",$smtpUsername);
  $smtpPassword              = str_replace("'","\'",$smtpPassword);
  $smtpPort                  = str_replace("'","\'",$smtpPort);
  $smtpHost                  = str_replace("'","\'",$smtpHost);
  $smtpAdminEmail            = str_replace("'","\'",$smtpAdminEmail);
  $smtpDefaultFrom           = str_replace("'","\'",$smtpDefaultFrom);
  $PHPMailerDebuggingFlag    = str_replace("'","\'",$PHPMailerDebuggingFlag);
  $dbType                    = str_replace("'","\'",$dbType);
  $dbHost                    = str_replace("'","\'",$dbHost);
  $dbUsername                = str_replace("'","\'",$dbUsername);
  $dbPassword                = str_replace("'","\'",$dbPassword);
  $dbName                    = str_replace("'","\'",$dbName);
  $GoogleOAuth2ClientID      = str_replace("'","\'",$GoogleOAuth2ClientID);
  $GoogleOAuth2ClientSecret  = str_replace("'","\'",$GoogleOAuth2ClientSecret);
  $FacebookOAuth2AppID       = str_replace("'","\'",$FacebookOAuth2AppID);
  $FacebookOAuth2AppSecret   = str_replace("'","\'",$FacebookOAuth2AppSecret);
  $googleAnalytics           = str_replace("'","\'",$googleAnalytics);
  
  $timezone                  = str_replace("'","\'",$timezone);

  
  //Build New Config File
  $newConfig="<?php

  global \$ASTRIA;

  \$ASTRIA = array(

    'app' => array(

      'defaultSessionLength'       => '".$defaultSessionLength."',
      'encryptionKey'              => '".$encryptionKey."',
      'appName'                    => '".$appName."',
      'appURL'                     => '".$appURL."',
      'favicon'                    => '".$favicon."'

    ),

    'debugging' => array(

      'showErrors'                 => ".var_export($showErrors, true).",
      'verbose'                    => ".var_export($verbose, true)."

    ),

    'smtp' => array(

      'username'                   => '".$smtpUsername."',
      'password'                   => '".$smtpPassword."',
      'port'                       => '".$smtpPort."',
      'host'                       => '".$smtpHost."',
      'adminEmail'                 => '".$smtpAdminEmail."',
      'defaultEmailFrom'           => '".$smtpDefaultFrom."',
      'PHPMailerDebuggingFlag'     => '".$PHPMailerDebuggingFlag."'
      
      /*
        0 = off (for production use)
        1 = client messages
        2 = client and server messages      
      */
    
    ),

    'databases'=>array(
      'astria' => array(

        'type'                     => '".$dbType."',
        'title'                    => 'Astria',
        'hostname'                 => '".$dbHost."',
        'username'                 => '".$dbUsername."',
        'password'                 => '".$dbPassword."',
        'database'                 => '".$dbName."',
        'resource'                 => false

      )
    ),

    'oauth'=>array(

      'Google' => array(

        'GoogleOAuth2ClientID'     => '".$GoogleOAuth2ClientID."',
        'GoogleOAuth2ClientSecret' => '".$GoogleOAuth2ClientSecret."'

      ),
      'Facebook' => array(

        'FacebookOAuth2AppID'     => '".$FacebookOAuth2AppID."',
        'FacebookOAuth2AppSecret' => '".$FacebookOAuth2AppSecret."'

      )
      

    ),
    'locale'=>array(
      'timezone' => '".$timezone."'
    ),
    'analytics' =>array(
      'Google' => '".$googleAnalytics."'
    )

  );
  
  ";
  
  $result=file_put_contents('config.php', $newConfig);
  if($result==false){
   die("Could not write config file. Please give write permission or copy the following into a new config.php file;\n\n".$newConfig); 
  }
  
  if($Exit){
    header('Location: /');
    exit;
  }
  
}
