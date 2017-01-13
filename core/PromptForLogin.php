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
				<?php global $NUMBER_OF_QUERIES_RUN,$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE, $DEBUG; echo 'Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4).' seconds. Ran '.$NUMBER_OF_QUERIES_RUN.' Database Queries. Ran '.$NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE.' Queries From Disk Cache.'; ?>
			</div>
		</div>
	</div>
	
	<?php
	  

}
