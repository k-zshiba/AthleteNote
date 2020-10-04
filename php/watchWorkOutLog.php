<?php
session_start();

if(!isset($_SESSION['userID'])){
    header("Location: loginPage.php");
    exit;
}

require_once('.\dbConfig.php');


try{
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("SELECT * FROM workoutlog WHERE userID = ? ORDER BY date ASC");
    $stmt->execute([$_SESSION['userID']]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch (\Exception $e){
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>ログ一覧</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h1><?php echo $_SESSION['userID'].'さん'; ?></h1>
  <h2>練習ログ一覧</h2>
  
  <table border=1>
    <tr>
      <th>日付</th>
      <th colspan=2>ユーザ名</th>
      <th>強度</th>
    </tr>
<?php
    foreach($row as $output){
        try{
            $pdo = new PDO(DSN, DB_USER, DB_PASS);
            $stmt = $pdo->prepare("SELECT * FROM contents WHERE contentID = ?");
            $stmt->execute([$output['contentID']]);
            $content = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (\Exception $e){
            exit($e->getMessage());
        }

        echo 
        '<tr>'.
          '<td colspan=1>'.$output['date'].'</td>'.
          '<td colspan=2>'.$_SESSION['userID'].'</td>'.
          '<td colspan=1>'.$output['intensity'].'</td>'.
        '</tr>'.
        '<tr>'.
          '<th colspan=4>メニュー</th>'.
        '</tr>'.
        '<tr>'.
          '<td colspan=4>'.$output['menu'].'</td>'.
        '</tr>'.
        '<tr>'.
          '<th colspan=4>感想・意識</th>'.
        '</tr>'.
        '<tr>'.
          '<td colspan=4>'.$output['thought'].'</td>'.
        '</tr>'.
        '<tr>'.
          '<th colspan=4>写真・動画</th>'.
        '</tr>'.
        '<tr>';
        if (isset($content['content1'])) {
          echo '<td colspan=2>'. '<img src="'.$content['content1'].'" style="width:100%;">'.'</td>';
        }else {
            echo '<td colspan=2></td>';
        }
        if (isset($content['content2'])) {
            echo '<td colspan=2>'. '<img src="'.$content['content2'].'" style="width:100%;">'.'</td>
            </tr>';
        }else {
            echo '<td colspan=2></td>
            </tr>';
        }
        echo 
        '<tr>'.
          '<form method="POST" action="editWorkOutLog_form.php">'.
            '<td>'. '<button type="submit" name="edit-button"value="'.$output['contentID'].'">編集</button></td>'.
          '</form>'.
          '<form method="POST" action="deletePhysicalConditionLog.php">'.
            '<td>'. '<button type="submit" name="delete-button"value="'.$output['contentID'].'">削除</button></td>'.
          '</form>';
        '</tr>';
    }
?>
  </table>
<button type="button" onclick="location.href = '.\\topPage.php'">トップに戻る</button>
</body>
</html>