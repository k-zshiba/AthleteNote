<?php
session_start();

require_once('..\dbConfig.php');

if(!isset($_SESSION['userID'])){
  header("Location: loginPage.php");
  exit;
}

// create user folder
$user_id = $_SESSION['userID'];
$error_message = "";
$contents_folder = "..\..\ContentsFolder";
$user_contents_folder = $contents_folder.'\\'.'user_'.$user_id;
if (empty(glob($contents_folder.'\*'.$user_id))) {
    mkdir($user_contents_folder, 0777, true);
}

if(empty($_POST['date'])){
  $error_message = "練習日を入力してください。";
  echo '<span>' . $error_message . '</span>';
}else{

  $date = $_POST['date'];
  $intensity = $_POST['intensity'];
  $thought = $_POST['thought'];
  $contentID = 'user_'.$user_id. date('YmsHis');
  $menu = $_POST['menu'];
  $content1_extension = pathinfo(basename($_FILES['content1']['name']),PATHINFO_EXTENSION);
  $content2_extension = pathinfo(basename($_FILES['content2']['name']),PATHINFO_EXTENSION);


  // 練習ログ登録
  try {
      $pdo = new PDO(DSN, DB_USER, DB_PASS);
      $stmt = $pdo->prepare("INSERT INTO workoutlog(userID, date, intensity, thought, contentID, menu) value(?,?,?,?,?,?)");
      $stmt->execute([$_SESSION['userID'], $date,$intensity,$thought,$contentID,$menu]);
      $add_contents_date_folder = $user_contents_folder.'\\'.$contentID;
      $content1 = $add_contents_date_folder.'\\'.'content1.'.$content1_extension;
      $content2 = $add_contents_date_folder.'\\'.'content2.'.$content2_extension;

      mkdir($add_contents_date_folder, 0777, true);
      if (move_uploaded_file($_FILES['content1']['tmp_name'],$content1) && (move_uploaded_file($_FILES['content2']['tmp_name'],$content2))) {
          $stmt = null;
          $pdo = null;
          header('Location: successRegister.php');
      }else {
          echo 'アップロードに失敗しました。';
      }
  }catch (PDOException $e) {
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
  <form action="" method = "POST" enctype="multipart/form-data">
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
    画像・動画(計二つまで)<br>
    <input type="file" name = "content1"><br>
    <input type="file" name = "content2"><br>
    練習メニュー<br>
    <textarea name="menu" rows="5" cols="40">ここに練習メニューを記入してください。</textarea><br>
    <button type="submit">登録する</button>
  </form>
</body>
</html>