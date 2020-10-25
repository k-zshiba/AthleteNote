<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ./loginPage.php");
    exit;
}

require_once('./htmlSpecialChars.php');
require_once('./connectDB.php');


try {
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT * FROM physicalconditionlog WHERE userID = ? ORDER BY date ASC");
    $stmt->execute([$_SESSION['userID']]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOExeption $e) {
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>ログ一覧</title>
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
  <!-- My script -->
  <script src="../javascript/deleteIsConfirmed.js"></script>
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
  <h1><?php echo $_SESSION['userID'].'さん'; ?></h1>
  <h2>体調ログ一覧</h2>
  <table border=1>
    <thead>
      <td>日付</td>
      <td>疲労度</td>
      <td>体重</td>
      <td>体温</td>
      <td>睡眠時間</td>
      <td>編集</td>
      <td>削除</td>

    </thead>
    <tbody>
    <?php
    foreach($row as $output){
        echo 
          '<tr>'.
            '<td>'. h($output['date']).'</td>'.
            '<td>'. h($output['fatigue']).'</td>'.
            '<td>'. h($output['bodyweight']).'</td>'.
            '<td>'. h($output['bodytemperature']).'</td>'.
            '<td>'. h($output['sleeptime']).'</td>'.
            '<form method="POST" action="editPhysicalConditionLog_form.php">'.
              '<td>'. '<button type="submit" class="btn btn-success" name="edit-button"value="'.h($output['physicalconditionlogID']).'">編集</button></td>'.
            '</form>'.
            '<form method="POST" action="deletePhysicalConditionLog.php" onSubmit = "return deleteIsConfirmed()">'.
              '<td>'. '<button type="submit" class="btn btn-danger" name="delete-button"value="'.h($output['physicalconditionlogID']).'">削除</button></td>'.
            '</form>'.
          '</tr>';
    }
    ?>
    </tbody>
  </table>
  <button type="button" class="btn btn-danger" onclick="location.href = './topPage.php'">トップに戻る</button>
</body>
</html>