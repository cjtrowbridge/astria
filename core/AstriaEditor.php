<?php

function AstriaEditor($Contents,$TextareaName){
  ?>
    
  <textarea class="AstriaEditor ready" name="<?php echo $TextareaName; ?>" id="<?php echo $TextareaName; ?>"><?php echo $Contents; ?></textarea>
  
  <script>AstriaEditor();</script>

  <?php
}
