<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ./loginPage.php");
    exit;
}

require_once('.\htmlSpecialChars.php');
require_once('.\dbConfig.php');


try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("SELECT * FROM physicalconditionlog WHERE userID = ? ORDER BY date ASC");
    $stmt->execute([$_SESSION['userID']]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOExeption $e) {
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>ログ一覧</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script>
  function deleteIsConfirmed(){
    if (window.confirm('本当に削除しますか？')) {
      return true
    }else {
      return false;
    }
  }
  </script>
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
            '<td>'. h($output['date']).'</td>'.
            '<td>'. h($output['fatigue']).'</td>'.
            '<td>'. h($output['bodyweight']).'</td>'.
            '<td>'. h($output['bodytemperature']).'</td>'.
            '<td>'. h($output['sleeptime']).'</td>'.
            '<form method="POST" action="editPhysicalConditionLog_form.php">'.
              '<td>'. '<button type="submit" name="edit-button"value="'.h($output['physicalconditionlogID']).'">編集</button></td>'.
            '</form>'.
            '<form method="POST" action="deletePhysicalConditionLog.php" onSubmit = "return deleteIsConfirmed()">'.
              '<td>'. '<button type="submit" name="delete-button"value="'.h($output['physicalconditionlogID']).'">削除</button></td>'.
            '</form>'.
          '</tr>';
    }
    ?>
    </tbody>
  </table>
  <button type="button" onclick="location.href = '.\\topPage.php'">トップに戻る</button>
</body>
</html>