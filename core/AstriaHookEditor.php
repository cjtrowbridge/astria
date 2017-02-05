<?php

function AstriaHookEditor($Contents,$FunctionName,$TextareaName){
  ?>
  
  <p>$Event['<?php echo $FunctionName; ?>'][] = function(){</p>
  <textarea class="AstriaHookEditor ready" name="<?php echo $TextareaName; ?>" id="<?php echo $TextareaName; ?>"><?php echo $Contents; ?></textarea>
  <p>}</p>
  
  <script>AstriaHookEditor();</script>

  <?php
}
