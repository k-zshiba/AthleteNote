<?php
$oauth_consumer_key = getenv('TWITTER_OAUTH_CONSUMER_KEY');
$oauth_consumer_secret = getenv('TWITTER_OAUTH_CONSUMER_SECRET');

define('OAUTH_CONSUMER_KEY',$oauth_consumer_key);
define('OAUTH_CONSUMER_SECRET',$oauth_consumer_secret);
$callback_url = 'https://athlete-note.herokuapp.com/php/twitterCallback.php';