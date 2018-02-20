<?php 

function AstriaWaitingRoom(){
	TemplateBootstrap4('Waiting','WaitingRoomBodyCallback();');
}
function WaitingRoomBodyCallback(){
	?>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1>Waiting</h1>
				<p>Welcome to the waiting room.</p>
				<a href="/logout">Log Out</a>
			</div>
		</div>
	</div>
	
	<?php
	  
}
