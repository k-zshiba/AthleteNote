<?php
session_start();

if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}

require_once('./connectDB.php');
require_once('./htmlSpecialChars.php');

$content_id = $_POST['edit-button'];
try {
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT * FROM workoutlog WHERE contentID = ? AND userID = ?");
    $stmt->execute([$content_id, $_SESSION['userID']]);
    $workout_log = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT * FROM contents WHERE contentID = ?");
    $stmt->execute([$content_id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$workout_log) {
        echo '該当するログが見つかりませんでした。<br>'.'<button type="button" onclick="location.href = \'./watchWorkOutLog.php\'">練習ログ一覧に戻る</button>';
        exit;
    }
}catch (PDOExeption $e) {
    exit($e->getMessage());
}
?>
<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>練習編集</title>
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
    <h2>練習編集</h2>
    <form action="editWorkOutLog.php" method = "POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="date"> 日付<span class="text-danger"> 編集不可</span></label>
          <div class="form-group">
            <div class="input-group date" id="date" data-target-input="nearest">
              <input name = "date" type="text" class="form-control datetimepicker-input" data-target="#date" data-toggle="datetimepicker" placeholder="<?php echo h($workout_log['date']);?>" value="<?php echo h($workout_log['date']);?>" required readonly/>
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
        <select name="intensity" class="custom-select my-1 mr-sm-2" id="intensity" placeholder="<?php echo h($workout_log['intensity']);?>">
          <option <?php if ($workout_log['intensity'] === '0'){echo "selected";}?>>強度</option>
          <option value=1 <?php if ($workout_log['intensity'] === 1){echo "selected";}?>>1</option>
          <option value=2 <?php if ($workout_log['intensity'] === 2){echo "selected";}?>>2</option>
          <option value=3 <?php if ($workout_log['intensity'] === 3){echo "selected";}?>>3</option>
          <option value=4 <?php if ($workout_log['intensity'] === 4){echo "selected";}?>>4</option>
          <option value=5 <?php if ($workout_log['intensity'] === 5){echo "selected";}?>>5</option>
        </select>
      </div>
      <div class="form-group">
        <label for="thought">ここに感想・意識を記入してください。</label>
        <textarea name="thought" class="form-control" id="thought" rows="3"><?php echo h($workout_log['thought']);?></textarea>
      </div>
      画像 (編集不可)<br>
      <?php 
      if (isset($content['content1'])) {
          echo '<td colspan=2>'. '<img src="'.$content['content1'].'" style="width:30%;">'.'</td>';
      }else {
          echo '<td colspan=2></td>';
      }
      if (isset($content['content2'])) {
          echo '<td colspan=2>'. '<img src="'.$content['content2'].'" style="width:30%;">'.'</td>
          </tr><br>';
      }else {
          echo '<td colspan=2></td>
          </tr>';
      }
      ?>
      <div class="form-group">
        <label for="menu">ここに練習メニューを記入してください。</label>
        <textarea name="menu" class="form-control" id="menu" rows="3"><?php echo h($workout_log['menu']);?></textarea>
      </div>
      <div class="form-check form-check-inline">
      <input class="form-check-input" name="open-or-close" type="radio" id="open-log" value="1" 
      <?php 
          if ($workout_log['openorclose'] === 1){
              echo "checked";
          }
      ?> required>
      <label class="form-check-label" for="open-log">公開する</label>
      </div>
      <div class="form-check form-check-inline">
      <input class="form-check-input" name="open-or-close" type="radio" id="close-log" value="0" 
      <?php if ($workout_log['openorclose'] === 0){
          echo "checked";
      }?> required>
      <label class="form-check-label" for="close-log">非公開</label>
      </div>
      <span class="text-danger">必須</span>
      <div class="float-right">
        <button  name="register-btn" class="btn btn-success" type="submit">登録する</button>
        <button type="button" class="btn btn-danger" onclick="location.href = './topPage.php'">トップに戻る</button>
      </div>
      <input name="contentID" type="text" value="<?php echo $content['contentID']?>" hidden>
    </form>
  </div>  
</body>
</html>
