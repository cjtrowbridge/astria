<?php

function AstriaFunctionEditor($Contents,$FunctionName,$TextareaName){
  ?>
  
  <p>&lt;?php </p>
  <?p>function <?php echo $FunctionName; ?>(){</p>
  <textarea class="AstriaFunctionEditor" name="<?php echo $TextareaName; ?>" id="<?php echo $TextareaName; ?>"><?php echo $Contents; ?></textarea>
  <p>}</p>
  <p>?&gt;</p>
  
  <?php
}
