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
  <style>
    label, label input, label select{
     display: block;
    }
  </style>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>Welcome To Astria Setup</h1>
        <p>We need some details in order to get started...</p>
        
        <form action="/" method="post">
          <h2>Your App</h2>
          <div class="form-group">
            <label>App Name (This will go in the titles):</label>
            <input type="text" name="appName" value="Astria" id="appName">
          </div>
          <script>
            $('#appName').focus();
          </script> 
          <div class="form-group">
            <label>App URL:</label>
            <input type="text" name="appURL" value="Astria">
          </div>
          <div class="form-group">
            <label>Favicon URL:</label>
            <input type="text" name="favicon" value="">
          </div>
          <div class="form-group">
            <label>Default Session Length (In seconds. Default is one week.):</label>
            <input type="text" name="defaultSessionLength" value="604800">
          </div>
          <div class="form-group">
            <label>Encryption Key:</label>
            <input type="text" name="encryptionKey" value="<?php echo MakeRandomString(32); ?>">
          </div>
          <h2>Mail</h2>
          <div class="form-group">
            <label>SMTP Server:</label>
            <input type="text" name="smtpHost" value="localhost">
          </div>
          <div class="form-group">
            <label>SMTP Port:</label>
            <input type="text" name="smtpPort" value="25">
          </div>
          <div class="form-group">
            <label>SMTP Username:</label>
            <input type="text" name="smtpUsername" value="">
          </div>
          <div class="form-group">
            <label>SMTP Password:</label>
            <input type="text" name="smtpPassword" value="">
          </div>
          
          <h2>Core Database</h2>
          <p>You can use many databases, but let's talk about the one that holds the core data like user accounts and sessions.</p>
          <div class="form-group">
            <label>Type:</label>
            <select name="dbType">
              <option value="mysql">MySQL</option>
            </select>
          </div>
          <div class="form-group">
            <label>Database Hostname (This is usually localhost, but it cann be any hostname, IP, etc.):</label>
            <input type="text" name="dbHostname" value="localhost">
          </div>
          <div class="form-group">
            <label>Database Username:</label>
            <input type="text" name="dbUsername" value="">
          </div>
          <div class="form-group">
            <label>Database Password:</label>
            <input type="text" name="dbPassword" value="">
          </div>
          <div class="form-group">
            <label>Database Name:</label>
            <input type="text" name="dbName" value="astria">
          </div>
          
          <h2>Google OAuth</h2>
          <p><a href="https://console.developers.google.com/apis/credentials" target="_blank">Click Here</a> to go to the Google API console and create an OAuth credential set for your app. Then enter the keys here.</p>
          <div class="form-group">
            <label>Google OAuth2 ClientID:</label>
            <input type="text" name="GoogleOAuth2ClientID" value="">
          </div>
          <div class="form-group">
            <label>Google OAuth2 Client Secret:</label>
            <input type="text" name="GoogleOAuth2ClientSecret" value="">
          </div>
  
          <h2>Locale</h2>
          <div class="form-group">
            <label>Timezone:</label>
            <input type="text" name="timezone">
          </div>
          
          <input type="submit">
          
        </form>
        
      </div>
    </div>
</div>

<?php
}
