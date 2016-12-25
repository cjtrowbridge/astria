<?php

function setup(){
  require('core/SimplePage.php');
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
          <label>
            App Name (This will go in the titles):
            <input type="text" name="appName" value="Astria" id="appName">
          </label>
          <script>
            $('#appName').focus();
          </script> 
          <label>
            App URL:
            <input type="text" name="appURL" value="Astria">
          </label>
          <label>
            Favicon URL:
            <input type="text" name="favicon" value="">
          </label>
          
          <label>
            Default Session Length (In seconds. Default is one week.):
            <input type="text" name="defaultSessionLength" value="604800">
          </label>
          
          <label>
            Encryption Key:
            <input type="text" name="encryptionKey" value="<?php echo MakeRandomString(32); ?>">
          </label>
          
          <h2>Mail</h2>
          <label>
            SMTP Server:
            <input type="text" name="smtpHost" value="localhost">
          </label>
          <label>
            SMTP Port:
            <input type="text" name="smtpPort" value="25">
          </label>
          <label>
            SMTP Username:
            <input type="text" name="smtpUsername" value="">
          </label>
          <label>
            SMTP Password:
            <input type="text" name="smtpPassword" value="">
          </label>
          
          <h2>Core Database</h2>
          <p>You can use many databases, but let's talk about the one that holds the core data like user accounts and sessions.</p>
          <label>
            Type:
            <select name="dbType">
              <option value="mysql">MySQL</option>
            </select>
          </label>
          <label>
            Database Hostname (This is usually localhost, but it cann be any hostname, IP, etc.):
            <input type="text" name="dbHostname" value="localhost">
          </label>
          <label>
            Database Username:
            <input type="text" name="dbUsername" value="">
          </label>
          <label>
            Database Password:
            <input type="text" name="dbPassword" value="">
          </label>
          <label>
            Database Name:
            <input type="text" name="dbName" value="astria">
          </label>
          
          <h2>Google OAuth</h2>
          <p><a href="https://console.developers.google.com/apis/credentials" target="_blank">Click Here</a> to go to the Google API console and create an OAuth credential set for your app. Then enter the keys here.</p>
          <label>
            Google OAuth2 ClientID:
            <input type="text" name="GoogleOAuth2ClientID" value="">
          </label>
          <label>
            Google OAuth2 Client Secret:
            <input type="text" name="GoogleOAuth2ClientSecret" value="">
          </label>
  
          <h2>Locale</h2>
          <label>
            Timezone:
            <input type="text" name="timezone">
          </label>
          
          <input type="submit">
          
        </form>
        
      </div>
    </div>
</div>

<?php
}
