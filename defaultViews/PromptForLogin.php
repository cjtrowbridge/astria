<?php 

//Hook('User Is Not Logged In','PromptForLogin();');

function PromptForLogin(){
	TemplateBootstrap4('','PromptForLoginBodyCallback();');
}

function PromptForLoginBodyCallback(){
	?>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php Event('Auth Login Options'); ?>
			</div>
		</div>
	</div>
	
	<?php
	  

}
