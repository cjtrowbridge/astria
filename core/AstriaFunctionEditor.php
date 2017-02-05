<?php

function AstriaFunctionEditor($Contents,$FunctionName,$TextareaName){
  ?>
  
  <p>function <?php echo $FunctionName; ?>(){</p>
  <textarea class="AstriaFunctionEditor ready" name="<?php echo $TextareaName; ?>" id="<?php echo $TextareaName; ?>"><?php echo $Contents; ?></textarea>
  <p>}</p>
  
  <script>AstriaFunctionEditor();</script>

  <?php
}
