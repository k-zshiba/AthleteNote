<?php
session_start();

require_once('./connectDB.php');

if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}

// create user folder
$user_id = $_SESSION['userID'];
$error_message = "";
$contents_folder = "../ContentsFolder";
$user_contents_folder = $contents_folder.'/'.'user_'.$user_id;
if (empty(glob($contents_folder.'/*'.$user_id))) {
    mkdir($user_contents_folder, 0777, true);
}

if (isset($_POST['register-btn'])) {
  $date_create_from_format = date_create_from_format('Y-m-d', $_POST['date']);
  $date = date_format($date_create_from_format,'Y-m-d');
  $intensity = $_POST['intensity'];
  $thought = $_POST['thought'];
  $menu = $_POST['menu'];
  $contentID = $user_id.$date;    
  $open_or_close = $_POST['open-or-close'];

  // 練習ログ登録
  try {
      $pdo = connectDB();
      // workoutlog テーブルに登録する
      $stmt = $pdo->prepare("INSERT INTO workoutlog(userID, date, intensity, thought, menu, contentID,openorclose) value(?,?,?,?,?,?,?)");
      $stmt->execute([$_SESSION['userID'], $date,$intensity,$thought,$menu,$contentID,$open_or_close]);
      $user_content_folder_in_date = $user_contents_folder.'/'.$date;
      if (empty(glob($user_contents_folder.'/*'.$date))) {
        mkdir($user_content_folder_in_date, 0777, true);
      }
      if (isset($_FILES['content1'])) {
          $content1_extension = pathinfo(basename($_FILES['content1']['name']),PATHINFO_EXTENSION);
          $content1 = $user_content_folder_in_date.'/'.'content1.'.$content1_extension;
          move_uploaded_file($_FILES['content1']['tmp_name'],$content1);
      }else {
          $content1 = null;
      }
      if (isset($_FILES['content2'])) {
          $content2_extension = pathinfo(basename($_FILES['content2']['name']),PATHINFO_EXTENSION);
          $content2 = $user_content_folder_in_date.'/'.'content2.'.$content2_extension;
          move_uploaded_file($_FILES['content2']['tmp_name'],$content2);
      }else {
          $content2 = null;
      }
      // contents テーブルに登録する
      $stmt = $pdo->prepare("INSERT INTO contents(contentID, content1, content2) value(?,?,?)");
      $result = $stmt->execute([$contentID,$content1,$content2]);
      $stmt = null;
      $pdo = null;
      // header('Location: ./successRegister.php');
      // exit;
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
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- Bootstrap Javascript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!--Moment.js-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" integrity="sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=" crossorigin="anonymous"></script>
  <!-- Tempus Dominus -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
</head>
<body>
  <header class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-primary" href="../index.html">Athlete Note</a>
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-sliders-h"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="./php/loginPage.php">ログイン</a>
          <a class="dropdown-item" href="./php/signUpPage.php">サインアップ</a>
        </div>
      </li>
    </ul>
  </header>
  <div class="mx-auto col-md-6 col-sm-12">
  <h3>練習登録フォーム</h3>
    <form action="" method = "POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="date"> 日付<span class="text-danger"> 必須</span></label>
          <div class="form-group">
            <div class="input-group date" id="date" data-target-input="nearest">
              <input name = "date" type="text" class="form-control datetimepicker-input" data-target="#date" data-toggle="datetimepicker" required/>
              <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#date').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
            });
        </script>
      </div>
      <div class="form-group">
        <label class="my-1 mr-2" for="intensity">練習の強度</label>
        <select name="intensity" class="custom-select my-1 mr-sm-2" id="intensity">
          <option selected>強度</option>
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
        </select>
      </div>
      <div class="form-group">
        <label for="thought">ここに感想・意識を記入してください。</label>
        <textarea name="thought" class="form-control" id="thought" rows="3"></textarea>
      </div>
      画像 (計二つまで)<br>
      <div class="form-group">
        <div class="custom-file">
          <input type="file" name = "content1" class="custom-file-input" id="content1">
          <label class="custom-file-label" for="content1">1つ目のファイル</label>
        </div>
        <div class="custom-file">
          <input type="file" name = "content2" class="custom-file-input" id="content2">
          <label class="custom-file-label" for="content2">2つ目のファイル</label>
        </div>
      </div>
      <div class="form-group">
        <label for="menu">ここに練習メニューを記入してください。</label>
        <textarea name="menu" class="form-control" id="menu" rows="3"></textarea>
      </div>
      <div class="form-check form-check-inline">
      <input class="form-check-input" name="open-or-close" type="radio" id="open-log" value="1"required>
      <label class="form-check-label" for="open-log">公開する</label>
      </div>
      <div class="form-check form-check-inline">
      <input class="form-check-input" name="open-or-close" type="radio" id="close-log" value="0" required>
      <label class="form-check-label" for="close-log">非公開</label>
      </div>
      <span class="text-danger">必須</span>
      <div class="float-right">
        <button  name="register-btn" class="btn btn-success" type="submit">登録する</button>
        <button type="button" class="btn btn-danger" onclick="location.href = './topPage.php'">トップに戻る</button>
      </div>
    </form>
  </div>
</body>
</html>