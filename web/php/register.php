<?php
require_once('./dbConfig.php');

session_start();

// サインアップ
// POSTの確認

// form のバリデーション
$error_message = "";
$formHasError = false;

if (empty($_POST['userID'])) {
    $error_message = 'ユーザIDが入力されていません。<br>';
    $formHasError = true;
    echo $error_message;
}
if (empty($_POST['password']) || empty($_POST['passwordCheck'])) {
    $error_message = 'パスワードもしくは確認用パスワードが入力されていません。<br>';
    $formHasError = true;
    echo $error_message;
}else {
    if ($_POST['password'] != $_POST['passwordCheck']) {
        $error_message = 'パスワードが一致しません。<br>';
        $formHasError = true;
        echo $error_message;
    }
// 各formに適当な値が入っている場合
    if (!empty($_POST['userID'])&&$_POST['password'] == $_POST['passwordCheck']) {
        $user_id = $_POST['userID'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $check_password = password_hash($_POST['passwordCheck'], PASSWORD_DEFAULT);
        //データベースに接続
        try {
            $pdo = new PDO(DSN, DB_USER, DB_PASS);
            $stmt = $pdo->prepare("SELECT * FROM userdata WHERE userID = ?");
            $stmt->execute([$_POST['userID']]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!isset($row['userID'])) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO userdata(userID, password) VALUE (?,?)");
                    $stmt->execute([$user_id, $password]);
                    session_regenerate_id(true); //session_idを新しく生成し、置き換える
                    $_SESSION['userID'] = $user_id;
                    $stmt = null;
                    $pdo = null;
                    header('Location: ./topPage.php');
                }catch (\Exception $e) {
                    exit($e->getMessage());
                }
            }else{
                echo 'このユーザIDは既に登録されています。<br>'.'<button type="button" onclick="location.href=\'./loginPage.php\'">登録画面に戻る</button>';
                exit;
            }
          }catch (\Exception $e) {
              exit($e->getMessage()); 
          }
    }
}
if ($formHasError) {
    echo '<button type="button" onclick="location.href=\'./loginPage.php\'">登録画面に戻る</button>';
}
