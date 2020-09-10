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
  $dbh = new PDO(DSN, DB_USER, DB_PASS);

  $sql = "SELECT * FROM userdata where USERID =  $user_id;";
  $userIdisInDB = $dbh->query($sql);  
}
catch(PDOException $e)
{
  exit('データベース接続失敗。'.$e->getMessage());
}


// データベースにユーザIDをパスワードを登録