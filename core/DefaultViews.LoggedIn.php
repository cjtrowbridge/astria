<?php

Hook('User Is Logged In - No Presentation','MaybeDefaultHomepage();');

function MaybeDefaultHomepage(){
  switch(path(0)){
    case 'account':
      if(isset($_POST['First_Name'])){
        global $ASTRIA;
        $UserID = $ASTRIA['Session']['User']['UserID'];
        $FirstName = Sanitize($_POST['First_Name']);
        $LastName  = Sanitize($_POST['Last_Name']);
        $Photo     = Sanitize($_POST['Photo']);
        $SQL = "UPDATE User SET 
          FirstName = '".$FirstName."',
          FirstName = '".$LastName."',
          FirstName = '".$Photo."'
        WHERE 
          UserID = ".$UserID."
        ";
        Query($SQL);
        header('Location: /account/?message=Changes+Saved');
        exit;
      }
      TemplateBootstrap4('My Account','defaultViewsMyAccountBodyCallback();');
    case false:
      TemplateBootstrap4('','defaultViewsHomepageBodyCallback();');
      break;
  }
}

function defaultViewsMyAccountBodyCallback(){
  global $ASTRIA;
  $User = $ASTRIA['Session']['User'];
  ?><h1><div style="float: right; white-space: nowrap;"><a href="/logout"><i title="Log Out" class="material-icons">&#xE879;</i> Log Out</a></div>My Account</h1>
  
<?php
  if(isset($_GET['message'])){
    echo '<h2>'.$_GET['message'].'</h2>';
  }
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
  global $EVENTS;
  Event('User Is Logged In - Homepage Content');
  if(!(isset($EVENTS['User Is Logged In - Homepage Content']))){
    ?><h1>Welcome To Astria</h1>
    <p>Astria takes care of user management and manages databases so you can focus on developing an application.<p>
    <p>If you are seeing this default homepage for a logged in user, it is because no other page was loaded, or no functions were hooked to the "User Is Logged In - Homepage Content" event.</p>
    <p>My best practice for getting started is to fork <a href="https://github.com/cjtrowbridge/astria-blank-plugin" target="_blank">Astria Blank Plugin</a> on Github and clone it into the plugins directory. Then use architect to set up a webhook and start coding!</p>
    <p>Also, check out the various examples on <a href="https://github.com/cjtrowbridge/">my Github</a> of apps written as plugins for Astria.</p>
    <?php
  }
  
  
}
