<?php

function FetchDiv($URL){
  $ID = sha256(uniqid(true));
  ?>
  
  <span class="FetchDiv" id="<?php echo $ID; ?>"></span>
  <script>
    var URL='<?php echo $URL; ?>';
    $.get(URL,function(data){
      $('#<?php echo $ID; ?>').html(data);
    });
  </script>
  
  <?php
}
