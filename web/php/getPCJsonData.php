<?php

session_start();


if(!isset($_SESSION['userID'])){
    header("Location: ../loginPage.html");
    exit;
}
require_once('./dbConfig.php');
require_once('./htmlSpecialChars.php');
require_once('./getFirstDayOfTheWeek.php');
$today = date('Y-m-d');
$day_no_per_page = 7-1;
$first_day_of_the_week = getFirstDayOfTheWeek($today);
$last_day_of_the_week = date('Y-m-d',strtotime($first_day_of_the_week. "next Sunday"));
// $current_page = $_GET['page'];
// $current_page = 1;

// $start_no = ($current_page - 1) * $max_per_page;
// echo $current_page;
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $sql = 'SELECT * FROM physicalconditionlog WHERE userID = ? AND date BETWEEN ? AND ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['userID'],$first_day_of_the_week,$last_day_of_the_week]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($row);
    $json_file = array('fatigue'=>[],'date'=>[],'bodyweight'=>[],'bodytemperature'=>[],'sleeptime'=>[]);
    foreach ($row as $output) {
    array_push($json_file['fatigue'],$output['fatigue']);
    array_push($json_file['date'],$output['date']);
    array_push($json_file['bodyweight'],$output['bodyweight']);
    array_push($json_file['bodytemperature'],$output['bodytemperature']);
    array_push($json_file['sleeptime'],$output['sleeptime']);
    }
    $json_encoded_file = json_encode($json_file,JSON_UNESCAPED_UNICODE);
    header('Content-type: application/json');
    echo $json_encoded_file;
    $pdo = null;
    $stmt = null;
}catch (Exception $e) {
    $e->getMessage();
}
?>



