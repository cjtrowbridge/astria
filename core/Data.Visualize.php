<?php

function Visualize($Data, $Type = 'line',$ID = false,$Color = false, $Height = 250){
  //Maybe make up a unique id for the chart container
  if($ID == false){
    $ID = 'chart_'.md5(uniqid());
  }
  //If no colors passed, do a blank array.
  if(is_array($Color)){
    $Color = array();
  }
  
  $Labels   = array();
  $Datasets = array();
  
  foreach($Data as $Row){
    $First = true;
    foreach($Row as $Key => $Value){
      //we are assuming that the first column is the labels
      if($First){
        $Labels[]=$Value;
        $First = false;
      }else{
        $Datasets[VisualizeOrdinalize($Key)]['title'] = $Key;
        if(isset($Color[$Key])){
          $Datasets[VisualizeOrdinalize($Key)]['color'] = $Color[$Key];
        }else{
          $Datasets[VisualizeOrdinalize($Key)]['color'] = VisualizeRandomColor($Key);
        }
        $Datasets[VisualizeOrdinalize($Key)]['values'][] = (float)$Value;
      }
    }
  }
  
  $Output = array(
    'labels' => $Labels,
    'datasets' => $Datasets
  );
  
  $Output = json_encode($Output,JSON_PRETTY_PRINT);
  
  return '
  <div id="'.$ID.'">Loading Chart...</div>
  <script>
    let '.$ID.'_Data = '.$Output.';
    let chart = new Chart({
      parent: "#'.$ID.'",
      /*title: "My Awesome Chart",*/
      data: '.$ID.'_Data,
      type: "'.$Type.'", // bar, line, scatter, pie, percentage
      height: '.$Height.'
    });
  </script>
  ';
}


global $VisualizeRandomColor;
$VisualizeRandomColor = array();

function VisualizeRandomColor($Key){
  global $VisualizeRandomColor;
  if(isset($VisualizeRandomColor[$Key])){
    return $VisualizeRandomColor[$Key];
  }
  $WebSafeColors = array(
    'blue',
    'red',
    'green',
    'black',
    'gray',
    'white',
    'maroon',
    'yellow',
    'olive',
    'lime',
    'aqua',
    'teal',
    'navy',
    'fucshia',
    'purple'
  );
  $VisualizeRandomColor[$Key] = $WebSafeColors[rand(0,count($WebSafeColors)-1)];
  return $VisualizeRandomColor[$Key];
}


global $VisualizeOrdinalize;
$VisualizeOrdinalize = array();

function VisualizeOrdinalize($Key){
  global $VisualizeOrdinalize;
  if(isset($VisualizeOrdinalize[$Key])){
    return $VisualizeOrdinalize[$Key];
  }
  $VisualizeOrdinalize[$Key] = count($VisualizeOrdinalize);
  return $VisualizeOrdinalize[$Key];
}
