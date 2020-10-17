$(function() {
  $(document).on('click', ".pager-btn", async e=> {
  
    const page = $(e.target).val();
    console.log(this);
    const res = await get_json(page);
    createList(res);
    $(`.pager-btn[value=${page}]`).addClass('active');    
  })
  get_json(1).done(res=>{
    createList(res);
    $(`.pager-btn[value=1]`).addClass('active');    
  })
  
})
// });
function get_json(page) {
  return $.ajax({
    url: 'http://localhost:8888/get_json.php',
    type: 'GET',
    data: {
        page:page
    }
  })
}


function createList(res) {
      const user_list = res.current_page_contents.map(user=> {
          const gender = ['不明','男性','女性'][user.gender]
          return `<tr>
          <td>${escapeHTML(user.code)}</td>
          <td>${escapeHTML(user.name)}</td>
          <td>${escapeHTML(user.name_kana)}</td>
          <td>${gender}</td>
          <td>${user.created_at}</td>
          <td>${user.updated_at}</td>
          <td>
            <form method = "POST" action = "./update_form.php">
              <button type="submit">編集</button>
              <input type="hidden" name = "code" value ='${escape(user.code)}'>
            </form>
          </td>
          <td>
            <form method = "POST" action = "./delete.php" onSubmit = "return deleteIsConfirmed()">
              <button type="submit">削除</button>
              <input type="hidden" name = "code" value ='${escape(user.code)}'>
            </form>
          </td>
          </tr>`;
      });
      // console.log(page);
      const page_btn = [];
      for (let i=0;i<res.total_page;i++) {
        // if (i+1===page) {
          page_btn.push(`<button class="pager-btn" value="${i+1}">${i+1}</button>`);
        // }else if (i+1!==page) {
        //   page_btn.push(`<button class="pager-btn" value="${i+1}">${i+1}</button>`);
        // }
      }
      $('#user-list tbody').children('tr').remove();
      $('#user-list tbody').append(user_list);
      $('#page-button').children('button').remove();
      $('#page-button').append(page_btn);
}

function escapeHTML(val) {
  return $('<div />').text(val).html();
}

// asd.hoge();
