<?php 

Hook('User Is Not Logged In - No Presentation','PromptForLogin();');

function PromptForLogin(){
	TemplateBootstrap4('','PromptForLoginBodyCallback();');
}

function PromptForLoginBodyCallback(){
	?>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br><?php Event('Auth Login Options'); ?>
			</div>
		</div>
	</div>
	
	<?php
	  

}
