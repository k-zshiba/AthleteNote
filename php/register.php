<?php
require_once('config.php');

session_start();

// サインアップ
// POSTの確認

// form のバリデーション
$error_message = "";

  if(empty($_POST['userID'])){
    $error_message = 'ユーザIDが入力されていません。';
    echo $error_message;
  }
  if(empty($_POST['password'])){
    $error_message = 'パスワードが入力されていません。';
    echo $error_message;
  }
  if(empty($_POST['passwordCheck'])){
    $error_message = '確認用パスワードが入力されていません。';
    echo $error_message;
  }
  if($_POST['password'] != $_POST['passwordCheck']){
    $error_message = 'パスワードが一致しません。';
    echo $error_message,'<button type="button" onclick=history.back()>戻る</button>';
  }

  if(!empty($_POST['userID'])&&!empty($_POST['password'])&&!empty($_POST['passwordCheck'])&&$_POST['password'] == $_POST['passwordCheck']){
    $user_id = $_POST['userID'];
    $password = $_POST['password'];
    $check_password = $_POST['passwordCheck'];
    //データベースに接続
    try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
    } catch (PDOException $e){
      exit('データベース接続失敗。'.$e->getMessage());
    }




    // データベースにユーザID、パスワードを登録
    try {
      $stmt = $pdo->prepare("INSERT INTO userdata(userID, password) VALUE (?,?)");
      $stmt->execute([$user_id, $password]);
      echo '登録完了';
    } catch (\Exception $e){
      echo 'このユーザIDは登録されています。';
    }
  }
// ajaxでかく


