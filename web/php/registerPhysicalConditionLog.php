<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ./loginPage.php");
    exit;
}
require_once('./connectDB.php');

$error_message = "";

if (isset($_POST['register-btn'])) {
    $date_create_from_format = date_create_from_format('m/d/Y', $_POST['date']);
    $date = date_format($date_create_from_format,'Y-m-d');
    $fatigue = $_POST['fatigue'];
    $bodyweight = $_POST['bodyweight'];
    $bodytemperature = $_POST['bodytemperature'];
    $sleeptime = $_POST['sleeptime'];
  // data base接続
  try {
      $pdo = connectDB();
      $stmt = $pdo->prepare("INSERT INTO physicalconditionlog(userID, date, fatigue, bodyweight, bodytemperature, sleeptime) value(?,?,?,?,?,?)");
      $stmt->execute([$_SESSION['userID'], $date,$fatigue,$bodyweight,$bodytemperature,$sleeptime]);
      $result = $stmt->rowCount();
      if ($result) {
          header('Location: ./successRegister.php');
          exit;
      }else {
          echo '登録に失敗しました。';
      }
  }catch (PDOException $e) {
      exit('データベース接続失敗。'.$e->getMessage());
  }
}
?>



<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>体調登録</title>

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
    <h3>体調登録</h3>
    <form action="" method = "POST">
      <div class="form-group">
        <label for="date"> 日付<span class="text-danger"> 必須</span></label>
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
        <label class="my-1 mr-2" for="fatigue">疲労度</label>
        <select name="fatigue" class="custom-select my-1 mr-sm-2" id="fatigue">
          <option selected>疲労度</option>
          <option value=1>1</option>
          <option value=2>2</option>
          <option value=3>3</option>
          <option value=4>4</option>
          <option value=5>5</option>
        </select>
      </div>
      <div class="form-group">
        <label for="bodyweight">体重 (kg)</label>
        <input type="number" class="form-control" value = "50" name = "bodyweight"  step = "0.1"><br>  
      </div>
      <div class="form-group">
        <label for="bodytemperature">体温 (℃)</label>
        <input type="number" class="form-control" value = "35" name = "bodytemperature"  step = "0.1"><br>  
      </div>
      <div class="form-group">
        <label for="sleeptime">睡眠時間</label>
        <input type="number" class="form-control" value = "6" name = "sleeptime"  step = "0.5"><br>  
      </div>
      <div class="float-right">
        <button  name="register-btn" class="btn btn-success" type="submit">登録する</button>
        <button type="button" class="btn btn-danger" onclick="location.href = './topPage.php'">トップに戻る</button>
      </div>
    </form>
  </div>
</body>
</html>