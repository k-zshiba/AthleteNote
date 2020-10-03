<?php 
session_start();
require_once('./dbConfig.php');

if(isset($_SESSION['userID'])){
  echo '<h2>ようこそ'. htmlspecialchars($_SESSION['userID'], ENT_QUOTES, 'utf-8').'さん</h2>';
}else{
  header("Location: loginPage.php");
  exit;
}

try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $stmt = $pdo->prepare("SELECT * FROM physicalconditionlog WHERE userID = ?");
  $stmt->execute([$_SESSION['userID']]);
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $encoded_json_data = json_encode($row);
}catch (PDOExeption $e) {
  exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>トップ画面</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
</head>

<body>
  <h2>トップ画面</h2>
  <a href="registerLogPage\registerWorkOutLog.php">練習登録画面へ</a>
  <a href="registerLogPage\registerPhysicalConditionLog.php">体調登録画面へ</a>
  <a href=".\watchPCLog.php">体調ログ一覧へ</a>
  <a href=".\watchWorkOutLog.php">練習ログ一覧へ</a>
  <a href=".\logout.php">ログアウト</a>

  <!-- <canvas id="physicalcondition">
    <script>
      const canvas = document.getElementById('stage');
      let physical_condition_data = <?php echo  htmlspecialchars($encoded_json_data, ENT_QUOTES, 'utf-8');?>;
      const chart = new Chart(canvas, {
      type: 'line',  //グラフの種類
      data: physicalcondition,  //表示するデータ
      options: options  //オプション設定
      });
    </script>
  
  </canvas> -->
</body>
</html>