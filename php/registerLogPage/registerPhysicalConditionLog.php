<?php
// require_once('.\dbConfig.php');

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
  <h2>体調登録</h2>
  <form action="" method = "POST">
    日付<br>
    <input type="date" name = "date"><br>
    疲労度<br>
    <input type="number" name = "fatigue" list = "fatigue" min = "1" max = "5"><br>
      <datalist id="fatigue">
      <option value=1>
      <option value=2>
      <option value=3>
      <option value=4>
      <option value=5>
      </datalist>  
    体重<br>
    <input type="number" value = "50" name = "bodyweight"  step = "0.1">kg<br>  
    体温<br>
    <input type="number" value = "35.0" name = "bodytemperature" step = "0.1">℃<br>
    睡眠時間<br>
    <input type="number" value = "6" name = "sleeptime" step = "0.5">時間<br> 
    <input type="submit" value = "登録する">
  </form>

</body>
</html>
