<?php

function setup(){
  require('core/SimplePage.php');
  require('core/MakeRandomString.php');
  require('core/RequireSSL.php');
  RequireSSL();
  
  if(isset($_POST['appName'])){
    setupHandler();
  }
  SimplePage('Astria Setup','setupBodyCallback();');
}

function setupBodyCallback(){
  //TODO make timezone a dropdown
  //TODO link to documentation with best practices and examples for setting up databases and mail servers
  //TODO support more database types
  //TODO support other oauth providers 
  //TODO support native email signups
?>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>Welcome To Astria Setup</h1>
        <p>We need some details in order to get started...</p>
        
        <form action="/" method="post">
          
          <h2>Your App</h2>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">App Name:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="appName" value="Astria" id="appName">
              <small class="form-text text-muted">This will go in the titles.</small>
            </div>
          </div>
          <script>
            $('#appName').focus();
          </script> 
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">App URL:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="appURL" value="Astria">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Favicon URL:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="favicon" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Default Session Length:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="defaultSessionLength" value="604800">
              <small class="form-text text-muted">In seconds. Default is one week.</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Encryption Key:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="encryptionKey" value="<?php echo MakeRandomString(32); ?>">
            </div>
          </div>
          <h2>Mail</h2>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">SMTP Server:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="smtpHost" value="localhost">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">SMTP Port:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="smtpPort" value="25">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">SMTP Username:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="smtpUsername" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">SMTP Password:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="smtpPassword" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Admin Email:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="smtpAdminEmail" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Default From:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="smtpDefaultFrom" value="">
            </div>
          </div>
          
          <h2>Core Database</h2>
          <p>You can use many databases, but let's talk about the one that holds the core data like user accounts and sessions.</p>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Type:</label>
            <div class="col-xs-10">
              <select class="form-control" name="dbType">
                <option value="mysql">MySQL</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Database Hostname:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="dbHostname" value="localhost">
              <small class="form-text text-muted">This is usually localhost, but it cann be any hostname, IP, etc..</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Database Username:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="dbUsername" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Database Password:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="dbPassword" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Database Name:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="dbName" value="astria">
            </div>
          </div>
          
          <h2>Google OAuth</h2>
          <p><a href="https://console.developers.google.com/apis/credentials" target="_blank">Click Here</a> to go to the Google API console and create an OAuth credential set for your app. Then enter the keys here.</p>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">ClientID:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="GoogleOAuth2ClientID" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Client Secret:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="GoogleOAuth2ClientSecret" value="">
            </div>
          </div>
  
          <h2>Locale</h2>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Timezone:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="timezone">
            </div>
          </div>
          
          <input class="form-control" type="submit">
          
        </form>
        <br>
        <br>
      </div>
    </div>
</div>

<?php
}

function setupHandler(){
  
  UpdateConfig(
    $_POST['defaultSessionLength'],
    $_POST['encryptionKey'],
    $_POST['appName'],
    $_POST['appURL'],
    $_POST['favicon'],
    $_POST['showErrors'],
    $_POST['verbose'],
    $_POST['smtpUsername'],
    $_POST['smtpPassword'],
    $_POST['smtpPort'],
    $_POST['smtpHost'],
    $_POST['smtpAdminEmail'],
    $_POST['smtpDefaultFrom'],
    $_POST['PHPMailerDebuggingFlag'],
    $_POST['dbType'],
    $_POST['dbHost'],
    $_POST['dbUsername'],
    $_POST['dbPassword'],
    $_POST['dbName'],
    $_POST['GoogleOAuth2ClientID'],
    $_POST['GoogleOAuth2ClientSecret'],
    $_POST['timezone']
  );

  header('Location: /');
  exit;
  
}
