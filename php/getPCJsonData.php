<?php

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
// // echo $current_page;
// try {
//     $pdo = new PDO(DSN, DB_USER, DB_PASS);
//     $sql = 'SELECT * FROM user';
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute();
//     $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $toral_page = ceil(count($row)/$max_per_page);
//     $sql = 'SELECT * FROM user LIMIT :start,:end';
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindParam(':start', $start_no, PDO::PARAM_INT);
//     $stmt->bindParam(':end', $max_per_page, PDO::PARAM_INT);
//     $stmt->execute();
//     $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     // $row = $stmt->fetchAll();
//     $json_file = array();
//     $json_file['total_page'] = $toral_page;
//     $json_file['current_page_contents'] = $row;
//     // $json_file = $row;
//     $json_encoded_file = json_encode($json_file,JSON_UNESCAPED_UNICODE);
//     header('Content-type: application/json');
//     echo $json_encoded_file;
//     $pdo = null;
//     $stmt = null;
// }catch (Exception $e) {
//     $e->getMessage();
// }
?>



