<?php 

function PromptForLogin(){
	Hook('Template Body','PromptForLoginBodyCallback();');
	TemplateBootstrap4();
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
