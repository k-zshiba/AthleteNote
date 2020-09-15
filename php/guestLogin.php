<?php

require_once('../dbConfig.php');

session_start();

// data base接続
try{
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
} catch(PDOException $e){
  exit('データベース接続失敗。'.$e->getMessage());
}


// ゲストユーザ登録
try {
  $stmt = $pdo->preprare("INSERT INTO guestuser(userID) value(?)");
  $stmt->execute()
} catch (PDOException $e){
  exit($e->getMessage());
}