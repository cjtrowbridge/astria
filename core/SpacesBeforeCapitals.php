<?php

function SpacesBeforeCapitals($String){
  return preg_replace('/(?<!\ )[A-Z]/', ' $0', $String);
}
