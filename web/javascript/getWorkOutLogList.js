$(function() {
  $(document).on('click', ".pager-btn", async e=> {
  
    const current_page = $(e.target).val();
    const res = await get_json(current_page);
    createWorkOutList(res);
    $(`.pager-btn[value=${current_page}]`).addClass('active');    
  })
  get_json(1);
})


function get_json(current_page) {
  $.ajax({
    url: '../php/getWorkOutLogJsonData.php',
    type: 'GET',
    data: {
      current_page:current_page
    }
  }).done(res=>{
    createWorkOutList(res);
    $(`.pager-btn[value=${current_page}]`).addClass('active');
  })
}

function createWorkOutList(res) {
  const json_data = res;
  const total_page = json_data.total_page;
  const workout_log = json_data.workout_log;
  const content = json_data.content;
  const workout_log_list = [];
  for (let i=0;i < workout_log.length;i++) {
    let workout_content =       
    `<div class="col-12 col-sm-6 col-md-4 workout-content">
      <table class="table table-bordered table-info">
        <tr>
          <td colspan=1>日付：</br>${escapeHTML(workout_log[i]['date'])}</td>
          <td colspan=2>ユーザ名：</br>${escapeHTML(workout_log[i]['userID'])}</td>
          <td colspan=1>強度：</br>${escapeHTML(workout_log[i]['intensity'])}</td>
        </tr>
        <tr>
          <th colspan=4>メニュー</th>
        </tr>
        <tr>
          <td colspan=4 style="height:100px;">${escapeHTML(workout_log[i]['menu'])}</td>
        </tr>
        <tr>
          <th colspan=4>感想・意識</th>
        </tr>
        <tr>
          <td colspan=4 style="height:100px;">${escapeHTML(workout_log[i]['thought'])}</td>
        </tr>
        <tr>
          <th colspan=4>写真・動画</th>
        </tr>
        <tr>
        <td colspan=4 style="height:200px;">`;
    if (content[i][0] !== null) {
      workout_content += `<img class="m-1" src="${content[i][0]}" style="height:100%;width:45%;">`;
    }
    if (content[i][1] !== null) {
      workout_content += `<img class="m-1" src="${content[i][1]}" style="height:100%;width:45%;">`;
    }
    if (content[i][0] === null && content[i][1] === null){
      workout_content += "画像が登録されていません";
    }
        workout_content += '</td></table></div>';
    workout_log_list.push(workout_content);
    
  }

  const page_btn = [];
  for (let i=0;i<total_page;i++) {
    page_btn.push(`<button type=button class="pager-btn btn btn-dark" value="${i+1}">${i+1}</button>`);
  }
  $('#workout-list').children('.workout-content').remove();
  $('#workout-list').append(workout_log_list);
  $('#page-button').children('button').remove();
  $('#page-button').append(page_btn);
}

function escapeHTML(val) {
  return $('<div />').text(val).html();
}