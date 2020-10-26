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

if ($twitter_connection->getLastHttpCode() == 200) {
  echo 'ツイート完了しました。';
} else {
  echo 'ツイートに失敗しました。';
}
