<?php
session_start();

if(!isset($_SESSION['userID'])){
  header("Location: ..\loginPage.html");
  exit;
}
echo '登録完了', '<a href=".\topPage.php">トップ画面へ戻る</a>';
