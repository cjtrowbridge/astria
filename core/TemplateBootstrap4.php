<?php

function TemplateBootstrap4($title='',$BodyCallback = '',$Fluid=false){
  global $HAMBURGER, $ASTRIA, $USER;
  $HAMBURGER=array('Home'=>'/');

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="<?php echo $ASTRIA['app']['favicon']; ?>">

  <title><?php 
    if(!($title=='')){
      echo $title.' - ';
    }
    echo $ASTRIA['app']['appName']; 
  ?></title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/js/jquery.tablesorter.combined.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.bootstrap_4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.grey.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.ice.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.blue.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.metro-dark.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.3/css/theme.dark.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">

  <!--Theme-->
  <script src="/js/hamburgerMenu.js"></script>
  <script src="/js/astria.js"></script>
  <link rel="stylesheet" href="/css/hamburgerMenu.css">
  <link rel="stylesheet" href="/css/style.css">

  <?php Event('Template Head'); ?>
</head>

<body>

  <nav class="navbar navbar-fixed-top navbar-dark bg-primary container<?php if($Fluid){echo '-fluid';} ?>" id="topNav">
    <a class="navbar-brand" href="<?php echo $ASTRIA['app']['appURL']; ?>"><?php echo $ASTRIA['app']['appName']; ?></a>
    <ul class="nav navbar-nav">
      <?php
        
        ShowNav('main');
        
        if(LoggedIn()){
          ShowNav('main-logged-in');
        }else{
          ShowNav('main-not-logged-in');
        }
        
      ?>
      
    </ul>
    <?php if(LoggedIn()){ ?>
    <ul class="nav navbar-nav float-xs-right">
      <li class="nav-item">
        <a class="nav-link active" href="/logout">Log Out</a>
      </li>
      <li class="nav-item">
        <img id="userPhoto" src="<?php echo $ASTRIA['Session']['User']['Photo']; ?>">
      </li>
    </ul>
    <?php } ?>
  </nav>

  <div class="container<?php if($Fluid){echo '-fluid';} ?>" id="bodyContainer">

    <?php 
  
    if(trim($BodyCallback)==''){  
      Event('Template Body'); 
    }else{
      eval($BodyCallback);
    }
    
    ?>
  
  </div><!-- /.container -->
  <?php
    
    global $NUMBER_OF_QUERIES_RUN,$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE, $DEBUG;
    $Runtime = round(microtime(true)-$DEBUG[0]['timestamp'],4);
  
  ?>
  <div id="runtime" class="<?php if($Runtime>0.1){echo 'runtimeBad';} ?>" title="<?php echo 'Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4).' seconds.'; /*Ran '.$NUMBER_OF_QUERIES_RUN.' Database Queries. Ran '.$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE.' Queries From Disk Cache.';*/ ?>">
    <a href="https://github.com/cjtrowbridge/astria" target="_blank">Astria</a> Loaded in <?php echo  $Runtime; ?> Seconds
  </div>
  <script>
    /*
    FixTopPadding();
    $(window).resize(function(){
      FixTopPadding();
    });
    function FixTopPadding(){
      $('body').css(
        'padding-top',
        $('#topNav').outerHeight()
      );
    }
    */
  </script>

</body>
</html>
<?php
  exit;
}
