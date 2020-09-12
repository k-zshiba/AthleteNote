<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>ログイン画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>初めての方はこちら</h2>
        <form name="register" action="register.php" method="POST">



            <label for="InputUserID">ID</label>
            <input type="text" name ="userID" id="InputUserID" aria-describedby="IDHelp">
            <small id="IDHelp">IDを半角数字10桁で入力してください</small>



            <label for="InputPassword">Password</label>
            <input type="password" name ="password" id="InputPassword">
            <small id="passwordHelp">パスワードを入力してください</small>



            <input type="password" name ="passwordCheck" id="InputPasswordCheck">
            <small id="passwordCheckHelp">もう一度パスワードを入力してください</small>

            <button type="submit" id = "signUp">登録</button>
        </form>

  <h2>既に登録済みの方はこちら</h2>
        <form name="login" action="login.php" method="POST">

            <label for="InputUserID">ID</label>
            <input type="text" name ="userID" id="InputUserID" aria-describedby="IDHelp">
            <small id="IDHelp">IDを半角数字10桁で入力してください</small>

            <label for="InputPassword">Password</label>
            <input type="password" name ="password" id="InputPassword">
            <small id="passwordHelp">パスワードを入力してください</small>

            <button type="submit">ログイン</button>
        </form>
        <h2>登録せずに使う</h2>
        <form name="guestLogin" action="guestLogin.php">
          <button type="submit">ゲストログイン</button>
        </form>
</body>
</html>

