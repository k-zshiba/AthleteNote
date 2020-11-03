<?php 
session_start();
require_once('./connectDB.php');

if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}

try {
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT * FROM physicalconditionlog WHERE userID = ?");
    $stmt->execute([$_SESSION['userID']]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $encoded_json_data = json_encode($row);
}catch (PDOExeption $e) {
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>トップ画面</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- Bootstrap Javascript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <!-- My script -->
  <script src="../javascript/getPCList.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-primary" href="../index.html">Athlete Note</a>
    <?php
        echo '<p class="mt-3">'. htmlspecialchars($_SESSION['userID'], ENT_QUOTES, 'utf-8').'さん</p>';
    ?>
    <ul class="navbar-nav mr-2 mr-sm-2 mr-md-2">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-sliders-h"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="./loginPage.php">ログイン</a>
          <a class="dropdown-item" href="./signUpPage.php">サインアップ</a>
        </div>
      </li>
    </ul>

  </nav>

  <div class="mt-4 row mx-auto">
    <div class="col-md-2 col-sm-4 col-6">
      <a class="btn btn-info mb-2" href="./registerWorkOutLog.php">練習登録画面へ</a>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
      <a class="btn btn-info mb-2" href="./registerPhysicalConditionLog.php">体調登録画面へ</a>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
      <a class="btn btn-info mb-2" href="./watchPCLog.php">体調ログ一覧へ</a>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
      <a class="btn btn-info mb-2" href="./watchWorkOutLog.php">練習ログ一覧へ</a>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
      <a class="btn btn-info mb-2" href="./watchWorkOutLogForOthers.php">他の人のログを見る</a>
    </div>  <div class="col-md-2 col-sm-4 col-6">
      <a class="btn btn-danger mb-2" href="./logout.php">ログアウト</a>
    </div> 
  </div>
  <div class="PC-chart-container col-12 d-inline-block" style="height: 600px;">
    <canvas id="PC-Chart"></canvas>
  </div>
  <div class="row">
    <div class="col-6 text-center">
      <i id="minus-one" class="fas fa-caret-square-left fa-5x"></i>
    </div>
    <div class="col-6 text-center">
      <i id="plus-one" class="fas fa-caret-square-right fa-5x"></i>
    </div>
  </div>
  <div class="row">
    <div class="col-6 text-center">
      <h4>前の月へ</h4>
    </div>
    <div class="col-6 text-center">
      <h4>次の月へ</h4>
    </div>
  </div>

    </div>  
  </div>

</body>
</html>