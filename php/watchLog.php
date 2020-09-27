<?php
session_start();

if(!isset($_SESSION['userID'])){
  header("Location: loginPage.php");
  exit;
}

require_once('.\dbConfig.php');


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
  <h1><?php echo $_SESSION['userID'].'さん'; ?></h1>
  <h2>体調ログ一覧</h2>
  <table border=1>
    <thead>
      <td>日付</td>
      <td>疲労度</td>
      <td>体重</td>
      <td>体温</td>
      <td>睡眠時間</td>
      <td>編集</td>
      <td>削除</td>

    </thead>
    <tbody>
    <?php
    foreach($row as $output){
        echo 
          '<tr>'.
            '<td>'. $output['date'].'</td>'.
            '<td>'. $output['fatigue'].'</td>'.
            '<td>'. $output['bodyweight'].'</td>'.
            '<td>'. $output['bodytemperature'].'</td>'.
            '<td>'. $output['sleeptime'].'</td>'.
            '<form method="POST" action="editPhysicalConditionLog.php">'.
              '<td>'. '<button type="submit" name="edit-button"value="'.$output['physicalconditionlogID'].'" readonly>編集</button></td>'.
            '</form>'.
            '<form method="POST" action="deletePhysicalConditionLog.php">'.
              '<td>'. '<button type="submit" name="delete-button"value="'.$output['physicalconditionlogID'].'" readonly>削除</button></td>'.
            '</form>'.
          '</tr>';
    }
    ?>
    </tbody>
  </table>

<button type="button" onclick="location.href = '.\\topPage.php'">トップに戻る</button>




</body>
</html>