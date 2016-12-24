<?php 

global $HAMBURGER, $ASTRIA;
$HAMBURGER=array('Home'=>'/');

function TemplateBootstrap0(){
	
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" href="<?php echo $ASTRIA['app']['favicon']; ?>">
	
	<title><?php echo $ASTRIA['app']['appName']; ?></title>
	
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.26.0/js/jquery.tablesorter.widgets.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">
	
	<!--Theme-->
	<script src="/js/hamburgerMenu.js"></script>
	<link rel="stylesheet" href="/css/hamburgerMenu.css">
	<link rel="stylesheet" href="/css/style.css">
	
	<?php 
	
	Event('Template Head');
	
	?>
</head>

<body class="has-drawer">
	<div class="container">
		<nav class="navbar navbar-fixed-top navbar-inverse">
			<div class="container">
				<div id="navbar">
					<ul style="margin-bottom:0px; margin-top:7px; padding-left:0px; display:inline-block;">
						<i class="material-icons hamburgerButton">menu</i>
						<ul class="hamburgerMenu hamburgerClosed">
							
							<?php 
                
                Event('Template Build Hamburger');
                
                global $HAMBURGER;
                
								foreach($HAMBURGER as $key => $val){
									if(is_array($val)){
										?>
							
										<li>
											<a class="hamburgerNestedButton"><?php echo $key; ?><i class="material-icons hamburgerIcon">arrow_drop_down</i></a>
											<ul class="hamburgerNestedList">
												<?php 
												
												foreach($val as $key2 => $val2){
													?>
													<li><a href="<?php echo $val2; ?>"><?php echo $key2; ?></a></li>
													<?php
												}
												
												?>
											</ul>
										</li>
										
								<?php
										
									}else{
                  
										?>
										
                    <li><a href="<?php echo $val; ?>"><?php echo $key; ?></a></li>
										
                    <?php
                    
									}
                  
								} 
              ?>
							
							<?php if(LoggedIn()){ ?>
							<li>
								<a href="/login"><i style="vertical-align:middle;" class="material-icons">power_settings_new</i> Log In</a>
							</li>
							<?php
							}else{
							?>
							<li><hr style="margin-top:7px; margin-bottom:7px;"></li>
							<li>
								<a href="/change_password"><i style="vertical-align:middle;" class="material-icons">settings</i> Change Password</a>
							</li>
							<li>
								<a href="/logout"><i style="vertical-align:middle;" class="material-icons">power_settings_new</i> Log Out</a>
							</li>
							<?php 
							}
							?>
						</ul>
					</ul>
					
					<div style="display:inline-block; font-size:20px; vertical-align:top; padding-top:11px; padding-left:10px;">
						<span>
							<a href="/" style="color:white;" class="underlineOnHover"><?php echo $ASTRIA['app']['appName']; ?></a>
						</span>
					</div>
          
				</div>
			</div>
		</nav>
	</div>

	<div class="container body_container">
		<div class="row">
			<div class="col-xs-12">			
			  <?php Event('Template Body'); ?>
			</div>
		</div>
  </div>
  
	<script>
		$(document).ready(function(){
		  $('.dropdown-submenu a.opener').on("click", function(e){
		    $(this).next('ul').toggle();
		    e.stopPropagation();
		    e.preventDefault();
		  });
		});
	</script>
  
</body>
</html>
<?php
exit;

}
