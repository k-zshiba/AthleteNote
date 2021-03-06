<?php
session_start();
require_once('./connectDB.php');
require_once('./twitterConfig.php');
require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$access_token = $_SESSION['access_token'];
$twitter_connection = new TwitterOAuth(OAUTH_CONSUMER_KEY,OAUTH_CONSUMER_SECRET,$access_token['oauth_token'],$access_token['oauth_token_secret']);
$userdata = $twitter_connection->get("account/verify_credentials");

$media1 = $twitter_connection->upload('media/upload', ['media' => $_SESSION['content1']]);
$media2 = $twitter_connection->upload('media/upload', ['media' => $_SESSION['content2']]);
$tweet_sentence = $_SESSION['date']."\n".
'強度：'.$_SESSION['intensity']."\n".
'意識・感想：'.$_SESSION['thought']."\n".
'メニュー：'.$_SESSION['menu']."\n";

$parameters = [
    'status' => $tweet_sentence,
    'media_ids' => implode(',', [$media1->media_id_string, $media2->media_id_string])
];
$result = $twitter_connection->post('statuses/update', $parameters);


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- Bootstrap Javascript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <title>ツイート練習ログ</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-primary" href="../index.html">Athlete Note</a>
    <ul class="navbar-nav">
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
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDropdownMenuLink" aria-controls="navbarDropdownMenuLink" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="text-center col-12">
  <?php
  if ($twitter_connection->getLastHttpCode() == 200) {
    echo '<h2>ツイート完了しました。</h2>'.'<button type="button" class="btn btn-danger" onclick="location.href = \'./topPage.php\'">トップに戻るy</button>';
  } else {
    echo '<h2>ツイートに失敗しました。</h2>'.'<button type="button" class="btn btn-danger" onclick="location.href = \'./topPage.php\'">トップに戻るy</button>';
  }
  ?>
  </div>
</html>