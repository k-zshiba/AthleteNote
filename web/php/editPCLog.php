<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ./topPage.php");
    exit;
}

require_once('./dbConfig.php');

$userID = $_SESSION['userID'];
$fatigue = $_POST['fatigue'];
$date = $_POST['date'];
$bodyweight = $_POST['bodyweight'];
$bodytemperature = $_POST['bodytemperature'];
$sleeptime = $_POST['sleeptime'];
$physical_condition_log_id = $_POST['physicalconditionlogID'];
try{
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $sql = "UPDATE physicalconditionlog SET fatigue=:fatigue,date=:date,bodyweight=:bodyweight,bodytemperature=:bodytemperature, sleeptime=:sleeptime WHERE physicalconditionlogID = :physicalconditionlogID AND userID = :userID";
    $stmt = $pdo->prepare($sql);
    $physical_condition_log = array(':fatigue'=>$fatigue, ':date'=>$date,':bodyweight'=>$bodyweight,':bodytemperature'=>$bodytemperature,':sleeptime'=>$sleeptime, ':physicalconditionlogID'=>$physical_condition_log_id,':userID'=>$userID);
    $stmt->execute($physical_condition_log);
    $result = $stmt->rowCount();
    if ($result) {
        echo "編集に成功しました。<br>";
    }else {
        echo "編集に失敗しました。<br>";
    }
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

  <button type="button" onclick="location.href='./watchPCLog.php'">一覧に戻る</button>
</body>
</html>