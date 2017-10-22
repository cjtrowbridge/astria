<?php
 
Hook('Webhook','ClusteringWebhooks();');
function ClusteringWebhooks(){
  
}

Hook('User Is Not Logged In - Before Presentation','ClusteringPublicPageBefore();');
function ClusteringPublicPageBefore(){
  
}

Hook('User Is Not Logged In - Presentation','ClusteringPublicPage();');
function ClusteringPublicPage(){
  switch(path(0)){
    
  }
}

Hook('User Is Logged In - Before Presentation','ClusteringUserPageBefore();');
function ClusteringUserPageBefore(){
  
}

Hook('User Is Logged In - Presentation','ClusteringUserPage();');
function ClusteringUserPage(){
  switch(path(0)){
    
  }
  
}
