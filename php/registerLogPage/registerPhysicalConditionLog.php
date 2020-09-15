<?php
require_once('..\dbConfig.php');

session_start();

$error_message = "";

if(empty($_POST['date'])){
  $error_message = "登録日を入力してください。";
  echo $error_message;
}else{
  $fatigue = $_POST['fatigue'];
  $date = $_POST['date'];
  $bodyweight = $_POST['bodyweight'];
  $bodytemperature = $_POST['bodytemperature'];
  $sleeptime = $_POST['sleeptime'];


  // data base接続
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
  } catch(PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
  }

  try {
    $stmt = $pdo->prepare("INSERT INTO physicalconditionlog(userID, date, fatigue, bodyweight, bodytemperature, sleeptime) value(?,?,?,?,?,?)");
    $stmt->execute([$_SESSION['userID'], $date,$fatigue,$bodyweight,$bodytemperature,$sleeptime]);
    header('Location: successRegister.php');
  } catch(PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
  }
}
?>



<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>体調登録</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>体調登録</h2>
  <form action="" method = "POST">
    日付<span> 必須</span><br>
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