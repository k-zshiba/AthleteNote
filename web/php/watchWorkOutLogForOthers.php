<?php
session_start();

if(!isset($_SESSION['userID'])){
    header("Location: loginPage.php");
    exit;
}
require_once('.\htmlSpecialChars.php');
require_once('.\dbConfig.php');


try{
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("SELECT * FROM workoutlog WHERE  openorclose= ? ORDER BY date ASC");
    $stmt->execute([1]);
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
  <h2>練習ログ一覧</h2>
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
        '<table border=1 style="width:50%;">'.
        '<tr>'.
          '<td colspan=1>'.h($output['date']).'</td>'.
          '<td colspan=2>'.h($_SESSION['userID']).'</td>'.
          '<td colspan=1>'.h($output['intensity']).'</td>'.
        '</tr>'.
        '<tr>'.
          '<th colspan=4>メニュー</th>'.
        '</tr>'.
        '<tr>'.
          '<td colspan=4>'.h($output['menu']).'</td>'.
        '</tr>'.
        '<tr>'.
          '<th colspan=4>感想・意識</th>'.
        '</tr>'.
        '<tr>'.
          '<td colspan=4>'.h($output['thought']).'</td>'.
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
        '</table>'.
          '<form method="POST" action="editWorkOutLog_form.php">'.
            '<td>'. '<button type="submit" name="edit-button"value="'.h($output['contentID']).'">編集</button></td>'.
          '</form>'.
          '<form method="POST" action="deletePhysicalConditionLog.php">'.
            '<td>'. '<button type="submit" name="delete-button"value="'.h($output['contentID']).'">削除</button></td>'.
          '</form>';
    }
?>
<button type="button" onclick="location.href = '.\\topPage.php'">トップに戻る</button>
</body>
</html>