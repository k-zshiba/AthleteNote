<?php
require_once('config.php');

// サインアップ
// POSTの確認
$user_id = $_POST['userID'];
$password = $_POST['password'];
$check_password = $_POST['passwordCheck'];

//データベースに接続
try
{
  $dbh = new PDO(DSN,DB_USER,DB_PASS);

  $sql = "SELECT * FROM `userdata` WHERE 1;";
  
  $data = $dbh->query($sql);

  echo $data;
}
catch(PDOException $e)
{
  exit('データベース接続失敗。'.$e->getMessage());
}

echo $data;
// データベースにユーザIDをパスワードを登録