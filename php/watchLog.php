<?php
session_start();

if(!isset($_SESSION['userID'])){
  header("Location: loginPage.php");
  exit;
}

require_once('dbConfig.php');


try{
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $stmt = $pdo->prepare("SELECT * FROM physicalconditionlog WHERE userID = ? ORDER BY date ASC");
  $stmt->execute([$_SESSION['userID']]);
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch (\Exception $e){
  exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>ログ一覧</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>体調ログ一覧</h2>
<ul>
<?php
foreach($row as $output){
  echo "<li>日付: $output[date] 疲労度: $output[fatigue] 体重: $output[bodyweight] 体温: $output[bodytemperature] 睡眠時間: $output[sleeptime]<br></li>";
}
?>


</ul>





</body>
</html>