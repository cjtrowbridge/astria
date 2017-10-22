<?php

Hook('User Is Not Logged In','EmailNotConfirmed();');
function EmailNotConfirmed(){
  if(path(0)=='emailnotconfirmed'){
    Hook('Template Body','EmailNotConfirmedBodyCallback();');
  TemplateBootstrap4('Please Confirm Email Address');
  }
}

function EmailNotConfirmedBodyCallback(){
  ?><h1>Welcome Back!</h1>
  <p>It looks like we need to confirm your email address.</p>
  <p>I sent you a confirmation link. Please check your email and click on that link to confirm your email!</p>
  <?php
}
