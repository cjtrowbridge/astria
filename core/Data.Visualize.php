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
        $Datasets[$Key]['title'] = $Key;
        if(isset($Color[$Key])){
          $Datasets[$Key]['color'] = $Color[$Key];
        }else{
          $Datasets[$Key]['color'] = VisualizeRandomColor($Key);
        }
        $Datasets[$Key]['values'][] = $Value;
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
      type: "bar", // or "line", "scatter", "pie", "percentage"
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
  $VisualizeRandomColor[$Key] = $WebSafeColors[rand(0,count($WebSafeColors))];
  return $VisualizeRandomColor[$Key];
}

/*


  // Javascript
  let data = {
    labels: ["12am-3am", "3am-6am", "6am-9am", "9am-12pm",
      "12pm-3pm", "3pm-6pm", "6pm-9pm", "9pm-12am"],

    datasets: [
      {
        title: "Some Data", color: "light-blue",
        values: [25, 40, 30, 35, 8, 52, 17, -4]
      },
      {
        title: "Another Set", color: "violet",
        values: [25, 50, -10, 15, 18, 32, 27, 14]
      },
      {
        title: "Yet Another", color: "blue",
        values: [15, 20, -3, -15, 58, 12, -17, 37]
      }
    ]
  };

  let chart = new Chart({
    parent: "#chart", // or a DOM element
    title: "My Awesome Chart",
    data: data,
    type: 'bar', // or 'line', 'scatter', 'pie', 'percentage'
    height: 250
  });

*/
