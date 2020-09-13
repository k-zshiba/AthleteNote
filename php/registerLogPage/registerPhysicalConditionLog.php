<?php
require_once('dbConfig.php');

session_start();


?>



<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>ログイン画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>練習登録</h2>
  <form action="" method = "POST">
    日付<br>
    <input type="date" name = "date"><br>
    強度<br>
    <input type="number" name = "intensity" list = "intensity" min = "1" max = "5"><br>
      <datalist id="intensity">
      <option value=1>
      <option value=2>
      <option value=3>
      <option value=4>
      <option value=5>
      </datalist>  
    感想・意識<br>
    <textarea name="thought" rows="5" cols="40">ここに感想を記入してください。</textarea><br>
    画像・動画<br>
    <input type="file" name = "content" multiple><br>
    <input type="submit" value = "登録する">
  </form>

</body>
</html>
