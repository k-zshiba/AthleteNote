<?php
$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db =['dbName'] = ltrim($db['path'],'/');
define('DSN',"mysql:host={$db['host']};dbname={$db['host']};charset=utf8");
define('DB_USER',$db['user']);
define('DB_PASS',$db['pass']);
