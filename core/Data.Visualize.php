<?php

function Visualize($Data, $Type = 'line',$ID = false){
  
  //Maybe make up a unique id for the chart container
  if($ID = false){
    $ID = 'chart_'.md5(uniqid());
  }
  
  $Data = json_encode($Data);
  
  pd($Data);
  return '';
  
  return '
    let data = {
      labels: ["12am-3am", "3am-6am", "6am-9am", "9am-12pm", "12pm-3pm", "3pm-6pm", "6pm-9pm", "9pm-12am"],
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
    <div id="'.$ID.'">Loading Chart...</div>
    let chart = new Chart({
      parent: "#'.$ID.'",
      /*title: "My Awesome Chart",*/
      data: data,
      type: "bar", // or "line", "scatter", "pie", "percentage"
      height: 250
    });
  ';
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
