<?php

function AstriaEditor($Contents,$FunctionName,$TextareaName){
  ?>
    
  <textarea class="AstriaEditor ready" name="<?php echo $TextareaName; ?>" id="<?php echo $TextareaName; ?>"><?php echo $Contents; ?></textarea>
  
  <script>AstriaEditor();</script>

  <?php
}
