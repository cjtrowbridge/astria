<?php

function FieldMask($Input){
  
  foreach($Input as $Row => &$Field){
    
    //If this isn't an array, skip it.
    if(!(is_array($Field))){
      if(isset($_GET['verbose'])){
        echo '<p>Fieldmask is skipping a row because it is not an array:</p>';
        pd($Field);
      }
      continue;
    }
    
    foreach($Field as $Key => $Value){
      
      //Custom functions can hook in here
      Event('FieldMask Before');

      switch($Key){
        case 'UserInserted':
        case 'UserUpdated':
          //If this field is an integer UserID, change it to a user's name and link to the user's information.
          if(intval($Value)==0){break;}
          //TODO link to the user's profile once there are user profiles. for now, simply link to the schema route for that user which will probably become user profiles later.
          $Results = Query( "SELECT FirstName, LastName FROM User WHERE UserID = ".intval($Value) );
          //If a result is found, make the change
          if(count($Results)==1){
            $Value = '<a href="/astria/User/'.$Value.'">'.$Results[0]['FirstName'].' '.$Results[0]['LastName'].'</a>';
          }
          break;
      }
      
      //Custom functions can hook in here
      Event('FieldMask After');
    }
    
  }
  
  return $Input;
}
