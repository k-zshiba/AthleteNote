<?php
function connectDB () {
    $url = getenv('JAWSDB_URL');
    $db = parse_url($url);
    $db['dbName'] = ltrim($db['path'],'/');

    $dsn = "mysql:host={$db['host']};dbname={$db['dbName']};charset=utf8";
    $db_user = $db['user'];
    $db_pass = $db['pass'];

    // $dsn = 'mysql:host=localhost;dbname=athletenote';
    // $db_user = 'root';
    // $db_pass = 'TfxkC1YNa3bjwbWL';
    $driver_options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
  ];
    $pdo = new PDO($dsn, $db_user, $db_pass, $driver_options);
    return $pdo;
}


