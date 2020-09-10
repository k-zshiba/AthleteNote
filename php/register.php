<?php
require_once('config.php');

// サインアップ
// POSTの確認
$user_id = $_POST['userID'];
$password = $_POST['password'];
$check_password = $_POST['passwordCheck'];
// form のバリデーション
// ajaxでかく


//データベースに接続
try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
} catch (PDOException $e){
  exit('データベース接続失敗。'.$e->getMessage());
}

$sql = "SELECT * FROM userdata;";
$stmt = $pdo->query($sql); 


// データベースにユーザID、パスワードを登録
try {
  $stmt = $pdo->prepare("INSERT INTO userdata(userID, password) VALUE (?,?)");
  $stmt->execute([$user_id, $password]);
  $stmt = $pdo->query($sql); 
  echo '登録完了';
} catch (\Exception $e){
  echo 'このユーザIDは登録されています。';
}