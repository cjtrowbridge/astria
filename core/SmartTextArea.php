<?php

function SmartTextArea($Contents,$FunctionName,$TextareaName){
  ?>
    
  <textarea class="AstriaSmartEditor ready" name="<?php echo $TextareaName; ?>" id="<?php echo $TextareaName; ?>"><?php echo $Contents; ?></textarea>
  
  <script>AstriaSmartEditor();</script>

  <?php
}
