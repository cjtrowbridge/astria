<?php

Hook('User Is Logged In - No Presentation','MaybeDefaultHomepage();');

function MaybeDefaultHomepage(){
  switch(path(0)){
    case 'account':
      if(isset($_POST['FirstName'])){
        pd($_POST);
        exit;
      }
      TemplateBootstrap4('My Account','defaultViewsMyAccountBodyCallback();');
    case false:
      TemplateBootstrap4('Home Page','defaultViewsHomepageBodyCallback();');
      break;
  }
}

function defaultViewsMyAccountBodyCallback(){
  global $ASTRIA;
  $User = $ASTRIA['Session']['User'];
  ?><h1>My Account</h1>
  
<?php
  
  //Classify each column
  $Writeable=array(
    'First Name' => $User['FirstName'],
    'Last Name'  => $User['LastName'],
    'Photo'     => $User['Photo']
  );
  $Readable=array(
    'Email'     => $User['Email'],
    'Last Login' => $User['LastLogin'],
    'Signup Date' => $User['SignupDate']
  );
  
  ?>

  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <form action="/account" method="post">
          <?php echo AstriaBootstrapAutoForm($Writeable,$Readable); ?>
        </form>
      </div>
    </div>
  </div>

<?php
  
}

function defaultViewsHomepageBodyCallback(){
  ?><h1>Welcome To Astria</h1>
  <p>Astria takes care of user management and manages databases so you can focus on developing an application.<p>
  <p>If you are seeing this default homepage for a logged in user, it is because no other page was loaded.</p>
  <p>My best practice for getting started is to fork <a href="https://github.com/cjtrowbridge/astria-blank-plugin" target="_blank">Astria Blank Plugin</a> on Github and clone it into the plugins directory. Then use architect to set up a webhook and start coding!</p>
  <p>Also, check out the various examples on <a href="https://github.com/cjtrowbridge/">my Github</a> of apps written as plugins for Astria.</p>
  <?php
}
