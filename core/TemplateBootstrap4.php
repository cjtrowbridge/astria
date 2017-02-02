<?php

function TemplateBootstrap4($title=''){
  global $HAMBURGER, $ASTRIA;
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
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.3/js/jquery.tablesorter.combined.min.js"></script>
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

  <nav class="navbar navbar-fixed-top navbar-dark bg-primary container">
    <a class="navbar-brand" href="<?php echo $ASTRIA['app']['appURL']; ?>"><?php echo $ASTRIA['app']['appName']; ?></a>
    <ul class="nav navbar-nav">
      <?php
        if(LoggedIn()){
          if(isset($ASTRIA['nav'])){
            foreach($ASTRIA['nav'] as $link => $path){
              ?>
          
      <li class="nav-item<?php if(path()==ltrim($path,"/")){ echo ' active';} ?>">
        <a class="nav-link" href="<?php echo $path; ?>"><?php echo $link; ?></a>
      </li>
          
              <?php
            }
          }
        }
      ?>
      <li class="nav-item">
        <a class="nav-link" href="https://github.com/cjtrowbridge/astria"><span class="icon-github">GitHub</span></a>
      </li>
      
    </ul>
    <?php if(LoggedIn()){ ?>
    <ul class="nav navbar-nav float-xs-right">
      <li class="nav-item">
        <a class="nav-link active" href="/logout">Log Out</a>
      </li>
    </ul>
    <?php } ?>
  </nav>

  <div class="container" id="bodyContainer">

    <?php Event('Template Body'); ?>

  </div><!-- /.container -->

</body>
</html>
<?php
  exit;
}
