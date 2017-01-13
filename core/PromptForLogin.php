<?php 

function PromptForLogin(){
	Hook('Template Body','PromptForLoginBodyCallback();');
	TemplateBootstrap2();
}

function PromptForLoginBodyCallback(){
	?>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php Event('Auth Login Options'); ?>
			</div>
			<div class="col-xs-12">
				<?php echo 'Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4)." seconds. 'Ran '.$NUMBER_OF_QUERIES_RUN.' Queries.'; ?>
			</div>
		</div>
	</div>
	
	<?php
	  

}
