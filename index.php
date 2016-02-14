<?php
$em = "";
if (!isset($_GET['PIN']) || $_GET['PIN'] === '') {
        $em = 'PINコードを入力してください';
    } else {
    if(preg_match("/^[0-9]+$/",$_GET['PIN'])){
        $pin = $_GET['PIN'];

        include('config.php');

        // mysqlへの接続
        $mysqli = new mysqli($db['host'], $db['user'], $db['pass']);
        if ($mysqli->connect_errno) {
            print('<p>データベースへの接続に失敗しました</p>' . $mysqli->connect_error);
            exit();
        }

        // データベースの選択
        $mysqli->select_db($db['dbname']);

        // クエリの実行
        //pinコードからURLの検索
        $query = "select * from url_table where pin = $pin ";
        $result = $mysqli->query($query);
        if (!$result) {
            print('クエリーが失敗しました' . $mysqli->error);
            $mysqli->close();
            exit();
        }

        while ($row = $result->fetch_assoc()) {
            // URLの取り出し
            $url = $row['url'];
        }

        // クエリの実行
        //pinコードの削除
        $query = "delete from url_table where pin = $pin";
        $result = $mysqli->query($query);
        if (!$result) {
            print('クエリーが失敗しました' . $mysqli->error);
            $mysqli->close();
            exit();
        }

        // データベースの切断
        $mysqli->close();

        if (!isset($url) || $url === '') {
            $em = "PINコード'$pin'は登録されていません";
        } else {
            header("Location: $url");
            exit;
        }
    }
}
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TrandferURL</title>
    <meta name="viewport" content="width=device-width">
</head>
<body>
    <center>
    <h1>TrandferURL</h1>
    <h3><?php echo $em?></h3>
    <form method="get" action="">
        <input type="text" name="PIN" size="10" maxlength="4" pattern="[0-9]*" placeholder="PINコード">
    </form>
</center>
</body>
</html>
