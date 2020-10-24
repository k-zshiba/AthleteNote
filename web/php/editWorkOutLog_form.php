<?php
session_start();

if(!isset($_SESSION['userID'])){
    header("Location: ./loginPage.php");
    exit;
}

require_once('./connectDB.php');
$content_id = $_POST['edit-button'];
try {
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT * FROM workoutlog WHERE contentID = ? AND userID = ?");
    $stmt->execute([$content_id, $_SESSION['userID']]);
    $workout_log = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT * FROM contents WHERE contentID = ?");
    $stmt->execute([$content_id]);
    $content = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$workout_log) {
        echo '該当するログが見つかりませんでした。<br>'.'<button type="button" onclick="location.href = \'./watchWorkOutLog.php\'">練習ログ一覧に戻る</button>';
        exit;
    }
}catch (PDOExeption $e) {
    exit($e->getMessage());
}
?>
<!DOCTYPE html>
<html lamg="ja">
<head>
  <meta charset="utf-8">
  <title>練習編集</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
  <h2>練習編集</h2>
  <form action="editWorkOutLog.php" method = "POST" enctype="multipart/form-data">
    日付<br>
    <?php echo '<input type="date" name="date" value="'.$workout_log['date'].'"><br>'; ?>
    強度<br>
    <?php echo '<input type="number" name="intensity" list="intensity" min="1" max="5" value="'.$workout_log['intensity'].'"><br>
      <datalist id="fatigue">
      <option value=1>
      <option value=2>
      <option value=3>
      <option value=4>
      <option value=5>
      </datalist>';
    ?>
    感想・意識<br>
    <?php echo '<textarea name="thought" rows="5" cols="40">'.$workout_log['thought'].'</textarea><br>';?>  
    画像・動画(計二つまで)<br>
    <?php 
    if (isset($content['content1'])) {
        echo '<td colspan=2>'. '<img src="'.$content['content1'].'" style="width:30%;">'.'</td>';
    }else {
        echo '<td colspan=2></td>';
    }
    if (isset($content['content2'])) {
        echo '<td colspan=2>'. '<img src="'.$content['content2'].'" style="width:30%;">'.'</td>
        </tr><br>';
    }else {
        echo '<td colspan=2></td>
        </tr>';
    }
    ?>
    練習メニュー<br>
    <?php echo '<textarea name="menu" rows="5" cols="40">'.$workout_log['menu'].'</textarea><br>';
    ?>
    <input type="radio" name="open-or-close" value="1" id = "open-log" <?php if ($workout_log['openorclose'] === '1'):?> checked <?php endif; ?> required>
    <label for="open-log">公開する</label><br>
    <input type="radio" name="open-or-close" value="0" id = "close-log" <?php if($workout_log['openorclose'] === '0'):?> checked <?php endif; ?> required>
    <label for="close-log">非公開</label><br>
    <button type='submit' name ='contentID' value='<?php echo $content_id?>'>保存する</button>
  </form>
  <button type="button" onclick="location.href = './topPage.php'">トップに戻る</button>
</body>
</html>
