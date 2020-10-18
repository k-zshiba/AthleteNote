<?php
session_start();

if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}

require_once('.\dbConfig.php');
$physical_condition_log_id = $_POST['delete-button'];
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("DELETE FROM physicalconditionlog WHERE physicalconditionlogID = ? AND userID = ?");
    $stmt->execute([$physical_condition_log_id, $_SESSION['userID']]);
    $result = $stmt->rowCount();
    if ($result) {
        echo '削除に成功しました。<br>'.'<button type="button" onclick="location.href = \'./watchPCLog.php\'">体調ログ一覧に戻る</button>';
    }else {
        echo '削除に失敗しました。<br>'.'<button type="button" onclick="location.href = \'./watchPCLog.php\'">体調ログ一覧に戻る</button>';
    }
}catch (PDOExeption $e) {
    exit($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Delete</title>
</head>

<body>

  <button type="button" onclick="location.href='.\\topPage.php'">トップに戻る</button>
</body>
</html>
