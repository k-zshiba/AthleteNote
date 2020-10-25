<?php
session_start();

require_once('./twitterConfig.php');
require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$twitter_connection = new TwitterOAuth(OAUTH_CONSUMER_KEY,OAUTH_CONSUMER_SECRET);

$twitter_request_token = $twitter_connection->oauth('oauth/request_token',['oauth_callback'=>$callback_url]);

$_SESSION['oauth_token'] = $twitter_request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $twitter_request_token['oauth_token_secret'];

$authentication_url = $connection->url("oauth/authorize", ["oauth_token" => $_SESSION['oauth_token']]);

header('location:'.$authentication_url);
