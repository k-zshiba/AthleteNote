<?php
session_start();

if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}

$user_id = $_SESSION['userID'];
$contentID = $_POST['delete-button'];
$contents_folder = "../ContentsFolder";
$user_contents_folder = $contents_folder.'/'.'user_'.$user_id;
$user_content_folder_in_date = $user_contents_folder.'/'.$contentID;
require_once('./connectDB.php');
try {
    $pdo = connectDB();
    $stmt = $pdo->prepare("DELETE FROM workoutlog WHERE contentID = ?");
    $stmt->execute([$contentID]);
    $result_for_delete_workout_log = $stmt->rowCount();
    $stmt = $pdo->prepare("DELETE FROM contents WHERE contentID = ?");
    $stmt->execute([$contentID]);
    $result_for_delete_contents = $stmt->rowCount();   
    array_map('unlink', glob($user_content_folder_in_date.'/*'));
    if ($result_for_delete_workout_log && $result_for_delete_contents) {
        echo '削除に成功しました。<br>'.'<button type="button" onclick="location.href = \'./watchWorkOutLog.php\'">練習記録一覧に戻る</button>';
    }else {
        echo '削除に失敗しました。<br>'.'<button type="button" onclick="location.href = \'./watchWorkOutLog.php\'">練習記録一覧に戻る</button>';
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
