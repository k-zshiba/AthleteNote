<?php
session_start();
require_once('./connectDB.php');
require_once('./twitterConfig.php');
require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$access_token = $_SESSION['access_token'];

$twitter_connection = new TwitterOAuth(OAUTH_CONSUMER_KEY,OAUTH_CONSUMER_SECRET,$access_token['oauth_token'],$access_token['oauth_token_secret']);

$userdata = $connection->get("account/verify_credentials");



// データベースにユーザIDが存在しているか確認
try {
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT * FROM userdata where userID = ?");
    $stmt->execute([$_POST['userID']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}catch (\Exception $e) {
    echo $e->getMessage();
}

if (empty($_POST['password']) || empty($_POST['userID'])) {
    $error_message = 'ユーザIDもしくはパスワードが入力されていません。<br>'.'<button type="button" onclick="location.href=\'./loginPage.php\'">登録画面に戻る</button>';
    echo $error_message;
}else {
    if (!isset($row['userID'])) {
        echo 'ユーザIDまたはパスワードが間違っています。<br>'.'<button type="button" onclick="location.href=\'./loginPage.php\'">登録画面に戻る</button>';
    }else {
        $password = $_POST['password'];
        $correct_password = $row['password'];
//パスワード確認後sessionにユーザIDを渡す
        if (password_verify($password,$correct_password)) {
            session_regenerate_id(true); //session_idを新しく生成し、置き換える
            $_SESSION['userID'] = $row['userID'];
            header('Location: topPage.php');
            exit;
        }else {
            echo 'ユーザIDまたはパスワードが間違っています。<br>','<button type="button" onclick="location.href=\'./loginPage.php\'">登録画面に戻る</button>';
        }
    }
}
