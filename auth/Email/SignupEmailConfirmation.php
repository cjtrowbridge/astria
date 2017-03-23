<?php

Hook('User Is Not Logged In','SignupEmailConfirmation();');
function SignupEmailConfirmation(){
  if(path(0)=='signupemailconfirmation'){
    Hook('Template Body','SignupEmailConfirmationBodyCallback();');
    TemplateBootstrap4('Thanks For Signing Up!');
  }
}

function SignupEmailConfirmationBodyCallback(){
  ?><h1>Thanks For Signing Up!</h1>
  <p>Check your email for the confirmation link to complete the signup process.</p>
  <?php
}
