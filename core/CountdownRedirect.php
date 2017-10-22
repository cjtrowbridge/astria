<?php 

function CountdownRedirect($url = './?', $seconds = '5'){

	?>
<div id="countdown"></div>
<script>
$(function(){
  var count = <?php echo $seconds; ?>;
  countdown = setInterval(function(){
    $("#countdown").html('(<a href="<?php echo $url; ?>">continue</a>)('+count+")");
    if (count == 0) {
		$("#countdown").attr("id","not");     
		window.location = '<?php echo $url; ?>';	 
    }
    count--;
  }, 1000);
});
</script>
	<?php
  
}
