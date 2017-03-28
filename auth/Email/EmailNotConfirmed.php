<?php

function EmailNotConfirmed(){
  Hook('Template Body','EmailNotConfirmedBodyCallback();',true);
  TemplateBootstrap4('Something Went Wrong');
}
function EmailNotConfirmedBodyCallback(){
  ?><h1>Welcome Back!</h1>
  <p>It looks like we still need to confirm your email address. I sent you a fresh confirmation link. Please check your email and click on that link to confirm your email!</p>
  <?php
}
