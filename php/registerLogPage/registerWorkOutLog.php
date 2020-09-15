<?php
require_once('..\dbConfig.php');

session_start();

$user_id = $_SESSION['userID'];
$error_message = "";

if(empty($_POST['date'])){
  $error_message = "練習日を入力してください。";
  echo '<span>' . $error_message . '</span>';
}else{

  $date = $_POST['date'];
  $intensity = $_POST['intensity'];
  $thought = $_POST['thought'];
  $contents = $_POST['contents'];

  // data base接続
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
  } catch(PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
  }

  // 練習ログ登録
  try {
    $stmt = $pdo->prepare("INSERT INTO workoutlog(userID, date, intensity, thought, contents) value(?,?,?,?,?)");
    $stmt->execute([$_SESSION['userID'], $date,$intensity,$thought,$contents]);
    $stmt = null;
    $pdo = null;
    header('Location: successRegister.php');
  } catch(PDOException $e) {
    exit($e->getMessage());
  }

  // 新規メニュー登録
  try {
    $stmt = $pdo->prepare("INSERT INTO menu(userID, quality, quantity) value(?,?,?)");
    $stmt->execute([$_SESSION['userID'], $date,$intensity,$thought,$contents]);
    $stmt = null;
    $pdo = null;
    header('Location: successRegister.php');
  } catch(PDOException $e) {
    exit($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>練習登録</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>練習登録</h2>
  <form action="" method = "POST">
    日付<span> 必須</span><br>
    <input type="date" name = "date"><br>
    強度<br>
    <input type="number" name = "intensity" list = "intensity" min = "1" max = "5"><br>
      <datalist id="intensity">
      <option value=1>
      <option value=2>
      <option value=3>
      <option value=4>
      <option value=5>
      </datalist>  
    感想・意識<br>
    <textarea name="thought" rows="5" cols="40">ここに感想を記入してください。</textarea><br>
    画像・動画<br>
    <input type="file" name = "contents" multiple><br>
    練習メニュー<br>
    <input type="text"><br>
    <!-- 新規メニュー<br>
    質<input type="text" name = "quality" multiple><br>
    量<input type="text" name = "quantity" multiple><br>
    <datalist id="intensity">
      <option value=1>
      <option value=2>
      <option value=3>
      <option value=4>
      <option value=5>
      </datalist> 
    過去にしたメニュー<bbr> -->

    <?php // data base接続
    // try {
    //   $pdo = new PDO(DSN, DB_USER, DB_PASS);
    // } catch(PDOException $e) {
    //   exit('データベース接続失敗。'.$e->getMessage());
    // }

    //   // 練習ログ登録
    // try {
    //   $stmt = $pdo->prepare("SELECT* FROM menu where userID = ?");
    //   $stmt->execute($_SESSION['userID']);
    //   $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //   $stmt = null;
    //   $pdo = null;
    // } catch(PDOException $e) {
    //   exit($e->getMessage());
    // }

    // for($menu_num = 0; $menu_num <= count($row['menu']);$menu_num++){
    //   echo '<input type="radio" name= "menu" value = "'. $row['menuname']. '>';
    // }
    ?>

    <input type="submit" value = "登録する">
  </form>
</body>
</html>