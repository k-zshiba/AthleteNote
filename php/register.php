<?php
require_once('dbConfig.php');

session_start();

// サインアップ
// POSTの確認

// form のバリデーション
$error_message = "";

  if(empty($_POST['userID'])){
    $error_message = 'ユーザIDが入力されていません。';
    echo $error_message,'<button type="button" onclick=history.back()>戻る</button>';
  }
  if(empty($_POST['password'])||empty($_POST['passwordCheck'])){
    $error_message = 'パスワードもしくは確認用パスワードが入力されていません。';
    echo $error_message,'<button type="button" onclick=history.back()>戻る</button>';
  }else{
    if($_POST['password'] != $_POST['passwordCheck']){
      $error_message = 'パスワードが一致しません。';
      echo $error_message,'<button type="button" onclick=history.back()>戻る</button>';
    }
  // 各formに適当な値が入っている場合
    if(!empty($_POST['userID'])&&$_POST['password'] == $_POST['passwordCheck']){
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
        $stmt = $pdo->prepare("SELECT * FROM userdata where userID = ?");
        $stmt->execute([$_POST['userID']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!isset($row['userID'])){
          try {
            $stmt = $pdo->prepare("INSERT INTO userdata(userID, password) VALUE (?,?)");
            $stmt->execute([$user_id, $password]);
            session_regenerate_id(true); //session_idを新しく生成し、置き換える
            $_SESSION['userID'] = $user_id;
            $stmt = null;
            $pdo = null;
            header('Location: topPage.php');
          } catch (\Exception $e){
            exit($e->getMessage());
          }
        }else{
          exit('このユーザIDは既に登録されています。<button type="button" onclick=history.back()>戻る</button>');
          
        }
      } catch (\Exception $e){
        exit($e->getMessage()); 
      }
    }
  }

// ajaxでかく


