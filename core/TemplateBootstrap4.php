<?php

//TODO make this be not the beta branch of bootstrap

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

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
  
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/js/jquery.tablesorter.combined.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.bootstrap_4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.grey.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.ice.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.blue.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.8/css/theme.metro-dark.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.3/css/theme.dark.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

  <link rel="stylesheet" href="/css/treeview.css">
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
      <?php ShowNav('main-right-logged-in'); ?>
      <li class="nav-item">
        <a class="nav-link active" href="/logout"><i title="Log Out" class="material-icons">&#xE879;</i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="/account"><img id="userPhoto" src="<?php echo $ASTRIA['Session']['User']['Photo']; ?>"></a>
      </li>
    </ul>
    <?php } ?>
  </nav>

  <div class="container<?php if($Fluid){echo '-fluid';} ?> no-gutters" id="bodyContainer">

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
  
  <div id="debugSummary" style="display: none;">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <?php DebugShowSummary(); ?>
        </div>
      </div>
    </div>
  </div>
    
  <div id="runtime" class="<?php if($Runtime>0.1){echo 'runtimeBad';} ?>" title="<?php echo 'Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4).' seconds.'; ?>">
    <a href="javascript:void(0);" onclick="$('#debugSummary').slideToggle();"><?php echo  $Runtime; ?></a>
  </div>
  
  
  <script>
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
  </script>

</body>
</html>
<?php
  exit;
}
