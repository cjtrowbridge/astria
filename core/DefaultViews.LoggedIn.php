<?php

Hook('User Is Logged In - No Presentation','MaybeDefaultHomepage();');

function MaybeDefaultHomepage(){
  if(path(0)===false){
    Hook('Template Body','defaultViewsHomepageBodyCallback();');
    TemplateBootstrap4('Default Home Page');
  }
}
function defaultViewsHomepageBodyCallback(){
  ?><h1>Welcome To Astria</h1>
  <p>Astria takes care of user management and manages databases so you can focus on developing an application.<p>
  <p>If you are seeing this default homepage for a logged in user, it is because no other page was loaded.</p>
  <p>My best practice for getting started is to fork <a href="https://github.com/cjtrowbridge/astria-blank-plugin" target="_blank">Astria Blank Plugin</a> on Github and clone it into the plugins directory. Then use architect to set up a webhook and start coding!</p>
  <p>Also, check out the various examples on <a href="https://github.com/cjtrowbridge/">my Github</a> of apps written as plugins for Astria.</p>
  <?php
}
