<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>ログイン画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>ログインはこちら</h2>
        <form name="login" action="./login.php" method="POST">

            <label for="InputUserID">ID</label><br>
            <input type="text" name ="userID" id="InputUserID" aria-describedby="IDHelp">
            <small id="IDHelp">IDを半角数字10桁で入力してください</small><br>

            <label for="InputPassword">Password</label><br>
            <input type="password" name ="password" id="InputPassword">
            <small id="passwordHelp">パスワードを入力してください</small><br>

            <button type="submit">ログイン</button>
        </form>
</body>
</html>