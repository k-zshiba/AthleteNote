<?php
session_start();

require_once('./twitterConfig.php');
require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$twitter_request_token['oauth_token'] = $_SESSION['oauth_token']; 
$twitter_request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

var_dump($_REQUEST['oauth_token']);
var_dump($request_token['oauth_token']);

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    echo 'Twitterの認証に失敗しました。<br>'.'<button type="button" class="btn btn-danger" onclick="location.href=\'./topPage.php\'">トップに戻る</button>';
    exit;
}else if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] === $_REQUEST['oauth_token']) {
    $twitter_connection = new TwitterOAuth(OAUTH_CONSUMER_KEY,OAUTH_CONSUMER_SECRET,$twitter_request_token['oauth_token'],$twitter_request_token['oauth_token_secret']);
    $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
    $_SESSION['access_token'] = $access_token;
    session_regenerate_id();
    header('location: ./tweetWorkOutLog.php');
}
