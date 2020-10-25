<?php

require_once('./connectDB.php');

session_start();

// data base接続
try{
  $pdo = connectDB();
} catch(PDOException $e){
  exit('データベース接続失敗。'.$e->getMessage());
}


// ゲストユーザ登録
try {
  $sql = "SELECT MAX(guestID) FROM guestuser";
  $stmt = $pdo->query($sql);
  $guest_num = $stmt->fetch(PDO::FETCH_ASSOC);
  if(is_null($guest_num["MAX(guestID)"])){
    $guestuser = "GuestUser1";
  }else{
    $guestuser = "GuestUser".strval($guest_num["MAX(guestID)"]+1);
  }
  $stmt = $pdo->prepare("INSERT INTO guestuser(guestuser) value(?)");
  $stmt->execute([$guestuser]);
  session_regenerate_id(true);
  $_SESSION['userID'] = $guestuser;
  $stmt = null;
  $pdo = null;
  header('Location: ./topPage.php');
} catch (PDOException $e){
  exit($e->getMessage());
}