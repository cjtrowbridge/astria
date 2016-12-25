<?php

function setup(){
  require('core/SimplePage.php');
  require('core/MakeRandomString.php');
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
            <label class="col-xs-2 col-form-label">App Name (This will go in the titles):</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="appName" value="Astria" id="appName">
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
            <label class="col-xs-2 col-form-label">Default Session Length (In seconds. Default is one week.):</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="defaultSessionLength" value="604800">
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
            <label class="col-xs-2 col-form-label">Database Hostname (This is usually localhost, but it cann be any hostname, IP, etc.):</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="dbHostname" value="localhost">
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
            <label class="col-xs-2 col-form-label">Google OAuth2 ClientID:</label>
            <div class="col-xs-10">
              <input class="form-control" type="text" name="GoogleOAuth2ClientID" value="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-xs-2 col-form-label">Google OAuth2 Client Secret:</label>
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
        
      </div>
    </div>
</div>

<?php
}
