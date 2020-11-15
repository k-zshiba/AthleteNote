<?php

session_start();
if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}
require_once('./connectDB.php');
require_once('./htmlSpecialChars.php');
$max_per_page = 6;
$current_page = $_GET['current_page'];
// $current_page = 1;
$start_no = ($current_page - 1) * $max_per_page;
try{
  $pdo = connectDB();
  $stmt = $pdo->prepare("SELECT * FROM workoutlog WHERE openorclose= ? ORDER BY date ASC");
  $stmt->execute([1]);
  $all_workout_log = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $total_page = ceil(count($all_workout_log)/$max_per_page);
  $stmt = $pdo->prepare("SELECT * FROM workoutlog WHERE openorclose= ? ORDER BY date ASC LIMIT ?,?");
  $stmt->execute([1, $start_no, $max_per_page]);
  $workout_log_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch (\Exception $e){
  exit($e->getMessage());
}
$json_file = array();
$json_file['total_page'] = $total_page;
$json_file['workout_log'] = $workout_log_list;
$json_file['content'] = [];
foreach($workout_log_list as $output){
  try{
      $pdo = connectDB();
      $stmt = $pdo->prepare("SELECT * FROM contents WHERE contentID = ?");
      $stmt->execute([$output['contentID']]);
      $content = $stmt->fetch(PDO::FETCH_ASSOC);
      array_push($json_file['content'],[$content['content1'],$content['content2']]);
  }catch (\Exception $e){
      exit($e->getMessage());
  }
}
$json_encoded_file = json_encode($json_file,JSON_UNESCAPED_UNICODE);
header('Content-type: application/json');
echo $json_encoded_file;


