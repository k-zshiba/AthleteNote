<?php 
session_start();

if(isset($_SESSION['userID'])){
  echo '<h2>ようこそ'. htmlspecialchars($_SESSION['userID'], ENT_QUOTES, 'utf-8').'さん</h2>';
}
?>

<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>トップ画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>トップ画面</h2>

  <a href="registerLogPage\registerPhysicalConditionLog.php">練習登録画面へ</a>

  <a href="registerLogPage\registerPhysicalConditionLog.php">体調登録画面へ</a>



  <a href="registerLogPage\registerPhysicalConditionLog.php">ログ一覧へ</a>

</body>
</html>