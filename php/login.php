<?php
require_once('dbConfig.php');

session_start();

//データベースに接続
try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("SELECT * FROM userdata where userID = ?");
    $stmt->execute([$_POST['userID']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}catch (\Exception $e) {
    echo $e->getMessage();
}
// データベースにユーザIDが存在しているか確認
if (!isset($row['userID'])) {
    echo 'ユーザIDまたはパスワードが間違っています。','<button type="button" onclick=history.back()>戻る</button>';
    // return FALSE;
}
//パスワード確認後sessionにメールアドレスを渡す
$password = $_POST['password'];
$correct_password = $row['password'];
if (password_verify($password,$correct_password)) {
    session_regenerate_id(true); //session_idを新しく生成し、置き換える
    $_SESSION['userID'] = $row['userID'];
    header('Location: topPage.php');
    exit;
}else {
    echo 'ユーザID又はパスワードが間違っています。','<button type="button" onclick=history.back()>戻る</button>';
    return FALSE;
}