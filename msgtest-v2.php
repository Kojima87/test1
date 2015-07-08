<?php
require_once 'msgproc-v1.php';
readfile("msgproc-v1.js");

$logic = new MsgProc();

//　登録ボタンが押された
if( isset($_POST['write']) == true ) {
//  var_dump($_POST);
  $logic->writeMsgData();
}

//　削除ボタンが押された
if( isset($_POST['del']) == true ) {
//  var_dump($_POST);
  $button = key($_POST['del']);
//  var_dump($button);
  $logic->deleteMsgData($_POST,$button);
}

$stmt = $logic->getMsgData();

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>メッセージテスト</title>
</head>
<body>
<h1>メッセージテスト</h1>
<!-- データ入力フォーム -->
<form method="POST" action="">

  名前：
  <input type="text" name="m_name" size="30" value="" /><br />
  メールアドレス：
  <input type="text" name="m_mail" size="30" value="" /><br />
  メッセージ：<br />
  <textarea name="m_message" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" name="write" value="登録" />
</form>


<?php

     echo '<form method="POST" action="" onsubmit="return submitChk()">';
     $idx = 0;

// 取得したデータを一覧表示
  foreach($stmt as $row) {
    echo "<hr>{$row["m_id"]}：";
    if (!empty($row["m_mail"])) {
        echo "<a href=\"mailto:" . $row["m_mail"] . "\">"
        . $row["m_name"] . "</a>";
    }
    else {
        echo $row["m_name"];
    }
    echo "(" . date("Y/m/d H:i", strtotime($row["m_dt"])) . ")";
    echo "<p>" . nl2br($row["m_message"]) . "</p>";

    //　削除。返信も欲しい、DB項目を追加しないと
     echo sprintf('<input type="hidden" name="idno['.$idx.']" value="%s"  />',$row["m_id"]);
     echo '<input type="submit" name="del['.$idx.']" value="削除" />';
    $idx++;

}

?>

</body>
</html>

