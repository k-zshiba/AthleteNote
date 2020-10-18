<?php
session_start();

if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}

require_once('.\dbConfig.php');
$physical_condition_log_id = $_POST['edit-button'];
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("SELECT * FROM physicalconditionlog WHERE physicalconditionlogID = ? AND userID = ?");
    $stmt->execute([$physical_condition_log_id, $_SESSION['userID']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo '該当するログが見つかりませんでした。<br>'.'<button type="button" onclick="location.href = \'./watchPCLog.php\'">体調ログ一覧に戻る</button>';
        exit;
    }
}catch (PDOExeption $e) {
    exit($e->getMessage());
}
?>
<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>体調編集</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>体調編集</h2>
  <form action="editPCLog.php" method = "POST">
    日付<span> 必須</span><br>
    <?php echo '<input type="date" name="date" value="'.$row['date'].'"><br>'; ?>
    疲労度<br>
    <?php echo '<input type="number" name="fatigue" list="fatigue" min="1" max="5" value="'.$row['fatigue'].'"><br>
      <datalist id="fatigue">
      <option value=1>
      <option value=2>
      <option value=3>
      <option value=4>
      <option value=5>
      </datalist>  ';
    ?>
    体重<br>
    <?php echo '<input type="number" name="bodyweight" step="0.1" value="'.$row['bodyweight'].'">kg<br>';?>  
    体温<br>
    <?php echo '<input type="number" name="bodytemperature" step="0.1" value="'.$row['bodytemperature'].'">℃<br>';?>
    睡眠時間<br>
    <?php echo '<input type="number" name="sleeptime" step="0.5" value="'.$row['sleeptime'].'">時間<br>'.
    "<button type='submit' name ='physicalconditionlogID' value='$physical_condition_log_id'>保存する</button>";
    ?>
  </form>
  <button type="button" onclick="location.href = '.\\topPage.php'">トップに戻る</button>
</body>
</html>
