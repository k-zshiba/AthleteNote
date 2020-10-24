<?php
session_start();

if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}

require_once('./connectDB.php');
$contentID = $_POST['delete-button'];
try {
    $pdo = connectDB();
    $stmt = $pdo->prepare("DELETE FROM workoutlog WHERE contentID = ?");
    $stmt->execute([$contentID]);
    $result_for_delete_workout_log = $stmt->rowCount();
    $stmt = $pdo->prepare("DELETE FROM contents WHERE contentID = ?");
    $stmt->execute([$contentID]);
    $result_for_delete_contents = $stmt->rowCount();   
    if ($result_for_delete_workout_log && $result_for_delete_contents) {
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

  <button type="button" onclick="location.href='./topPage.php'">トップに戻る</button>
</body>
</html>
