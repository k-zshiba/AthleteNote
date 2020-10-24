<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ./topPage.php");
    exit;
}

require_once('./connectDB.php');

$userID = $_SESSION['userID'];
$intensity = $_POST['intensity'];
$date = $_POST['date'];
$thought = $_POST['thought'];
$menu = $_POST['menu'];
$content_id = $_POST['contentID'];
$open_or_close = $_POST['open-or-close'];
try{
    $pdo = connectDB();
    $sql = "UPDATE workoutlog SET intensity=:intensity,date=:date,thought=:thought, menu=:menu, openorclose=:openorclose WHERE contentID = :contentID AND userID = :userID";
    $stmt = $pdo->prepare($sql);
    $workout_log = array(':intensity'=>$intensity, ':date'=>$date,':thought'=>$thought,':menu'=>$menu,':openorclose'=>$open_or_close, ':contentID'=>$content_id,':userID'=>$userID);
    $stmt->execute($workout_log);
    $result = $stmt->rowCount();
    echo "編集に成功しました。<br>";
}catch (PDOExeption $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>insert</title>
</head>
<body>
  <button type="button" onclick="location.href='./watchWorkOutLog.php'">一覧に戻る</button>
</body>
</html>