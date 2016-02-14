<?php
$em = "";
if (!isset($_GET['URL']) || $_GET['URL'] === '') {
    $em = 'URLを入力してください';
} else {
    $url = $_GET['URL'];
    $pin = sprintf('%04d', rand(0, 9999));;

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
    //PINコードとURLを登録
    $query = "INSERT INTO `url_table` (`pin`, `url`) VALUES ('" .$pin. "', '" .$url. "')";
    $result = $mysqli->query($query);
    if (!$result) {
        print('クエリーが失敗しました' . $mysqli->error);
        $mysqli->close();
        exit();
    }

    // データベースの切断
    $mysqli->close();

    $em = "$url を登録しました<br>PINコード:$pin";
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
        <input type="url" name="URL" size="20" placeholder="URL">
    </form>
</center>
</body>
</html>
