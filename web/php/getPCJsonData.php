<?php

session_start();


if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}
require_once('./connectDB.php');
require_once('./htmlSpecialChars.php');
$add_to_this_month = $_GET['add_to_this_month'];
// $add_to_this_month = 0;
$current_showed_month = date('Y-m',strtotime("+".$add_to_this_month."month"));
$first_day_of_this_month = date('Y-m-d',strtotime('first day of'.$current_showed_month));
$last_day_of_this_month = date('Y-m-d',strtotime('last day of'.$current_showed_month));
try {
    $pdo = connectDB();
    $sql = 'SELECT * FROM physicalconditionlog WHERE userID = ? AND date BETWEEN ? AND ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['userID'],$first_day_of_this_month,$last_day_of_this_month]);
    $all_PC_log = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $sql = 'SELECT intensity AND date FROM workoutlog WHERE userID = ? AND date BETWEEN ? AND ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['userID'],$first_day_of_this_month,$last_day_of_this_month]);
    $all_intensity = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $json_file = array('fatigue'=>[],'PCDate'=>[],'bodyweight'=>[],'bodytemperature'=>[],'sleeptime'=>[],'workOutDate'=>[],'intensity'=>[]);
    foreach ($all_PC_log as $each_PC_log) {
        array_push($json_file['fatigue'],$each_PC_log['fatigue']);
        array_push($json_file['PCDate'],$each_PC_log['date']);
        array_push($json_file['bodyweight'],$each_PC_log['bodyweight']);
        array_push($json_file['bodytemperature'],$each_PC_log['bodytemperature']);
        array_push($json_file['sleeptime'],$each_PC_log['sleeptime']);
    }
    foreach ($all_intensity as $intensity) {
        array_push($json_file['workOutDate'],$intensity['date']);
        array_push($json_file['intensity'],$intensity['intensity']);
    }
    $pdo = null;
    $stmt = null;
    $json_encoded_file = json_encode($json_file,JSON_UNESCAPED_UNICODE);
    header('Content-type: application/json');
    echo $json_encoded_file;
}catch (Exception $e) {
    $e->getMessage();
}
?>



