<?php 

function GetCoordinatesByQuery($Query){
  
  //TODO add caching for these results
  
  $Address = urlencode($Query);
  if($Address==''){
    return false;
  }
  $URL = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $Address;
  $Response = file_get_contents($URL);
  $JSON = json_decode($Response,true);
  if(isset($JSON['results'][0])){
    $Latitude  = $JSON['results'][0]['geometry']['location']['lat'];
    $Longitude = $JSON['results'][0]['geometry']['location']['lng'];
    return array('latitude'=>$Latitude, 'longitude'=>$Longitude);
  }else{
    return false;
  }
  
}
