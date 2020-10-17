<?php
session_start();

require_once('.\dbConfig.php');

if(!isset($_SESSION['userID'])){
    header("Location: ..\loginPage.html");
    exit;
}

// create user folder
$user_id = $_SESSION['userID'];
$error_message = "";
$contents_folder = "..\ContentsFolder";
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
    $menu = $_POST['menu'];
    $contentID = $user_id.$date;    
    $open_or_close = $_POST['open-or-close'];

  // 練習ログ登録
    try {
        $pdo = new PDO(DSN, DB_USER, DB_PASS);
        // workoutlog テーブルに登録する
        $stmt = $pdo->prepare("INSERT INTO workoutlog(userID, date, intensity, thought, menu, contentID,openorclose) value(?,?,?,?,?,?,?)");
        $stmt->execute([$_SESSION['userID'], $date,$intensity,$thought,$menu,$contentID,$open_or_close]);
        $user_content_folder_in_date = $user_contents_folder.'\\'.$date;
        if (empty(glob($user_contents_folder.'\*'.$date))) {
          mkdir($user_content_folder_in_date, 0777, true);
        }
        if (isset($_FILES['content1'])) {
            $content1_extension = pathinfo(basename($_FILES['content1']['name']),PATHINFO_EXTENSION);
            $content1 = $user_content_folder_in_date.'\\'.'content1.'.$content1_extension;
            if (move_uploaded_file($_FILES['content1']['tmp_name'],$content1)) {
              $content1_is_uploaded = true;
            }else {
              $content1_is_uploaded = false;
            }
        }else {
            $content1 = null;
        }
        if (isset($_FILES['content2'])) {
            $content2_extension = pathinfo(basename($_FILES['content2']['name']),PATHINFO_EXTENSION);
            $content2 = $user_content_folder_in_date.'\\'.'content2.'.$content2_extension;
            if (move_uploaded_file($_FILES['content2']['tmp_name'],$content2)) {
                $content2_is_uploaded = true;
            }else {
                $content2_is_uploaded = false;
            }
        }else {
            $content2 = null;
        }
        // contents テーブルに登録する
        $stmt = $pdo->prepare("INSERT INTO contents(contentID, content1, content2) value(?,?,?)");
        $result = $stmt->execute([$contentID,$content1,$content2]);
        if ($content1_is_uploaded||$content2_is_uploaded) {
            $stmt = null;
            $pdo = null;
            header('Location: successRegister.php');
            exit;
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
    <input type="radio" name="open-or-close" id="open-log" value="1"required><label for="open-log">公開する</label>
    <input type="radio" name="open-or-close" id="close-log" value="0" required><label for="close-log">非公開</label><br>
    <button type="submit">登録する</button>
  </form>
  <button type="button" onclick="location.href = '.\\topPage.php'">トップに戻る</button>
</body>
</html>