$(function() {
  let add_to_this_month = 0;
  $(document).on('click', "#plus-one",async function() {  
    add_to_this_month += 1;
    const res = await get_json(add_to_this_month);
    createChart(res);
  })
  $(document).on('click', "#minus-one", async function() {  
    add_to_this_month -= 1;
    const res = await get_json(add_to_this_month);
    createChart(res);
  })
  get_json(add_to_this_month);
})


function get_json(add_to_this_month) {
  $.ajax({
    url: '../php/getPCJsonData.php',
    type: 'GET',
    data: {
      add_to_this_month:add_to_this_month
    }
  }).done(res =>{
    createChart(res);
  })
}

function createChart(res) {
  const json_data = res;
  const ctx = document.getElementById('PC-Chart').getContext('2d');
  const PC_Chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: json_data.PCDate,
      datasets: [{
        label: '疲労度',
        data: json_data.fatigue,
        borderColor: [
            'rgba(0, 45, 65, 1)'          ],
        fill:false,
        borderWidth: 1,
        lineTension: 0,
      },
      {
        label: '体重',
        data: json_data.bodyweight,
        borderColor: [
            'rgba(0, 45, 255, 1)'
        ],
        fill:false,
        borderWidth: 1,
        lineTension: 0,
      },
      {
        label: '体温',
        data: json_data.bodytemperature,
        borderColor: [
            'rgba(255, 99, 132, 1)'
        ],
        fill:false,
        borderWidth: 1,
        lineTension: 0,
      },
      {
        label: '睡眠時間',
        data: json_data.sleeptime,
        borderColor: [
            'rgba(255, 45, 255, 1)'
        ],
        fill:false,
        borderWidth: 1,
        lineTension: 0,
      }
      // {
      //   label: '睡眠時間',
      //   data: json_data.sleeptime,
      //   borderColor: [
      //       'rgba(255, 45, 255, 1)'
      //   ],
      //   fill:false,
      //   borderWidth: 1,
      //   lineTension: 0,
      // },
      // {
      //   label: '睡眠時間',
      //   data: json_data.sleeptime,
      //   borderColor: [
      //       'rgba(255, 45, 255, 1)'
      //   ],
      //   fill:false,
      //   borderWidth: 1,
      //   lineTension: 0,
      // },
    ]
    },
    options: {
      maintainAspectRatio: false,
      scales: {
        yAxes: [{
          stacked: true,
          gridLines: {
            display: true,
            color: "rgba(255,255,255,0.6)"
          }
        }],
        xAxes: [{
          gridLines: {
          display: true
          }
        }]
    }}
  });
}

  function escapeHTML(val) {
    return $('<div />').text(val).html();
  }