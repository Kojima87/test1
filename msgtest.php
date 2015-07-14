<?php
session_start();  // <?php　の直下に置かないとだめみたい
require_once 'msgproc.php';
try {

  $logic = new MsgProc();

    //　登録ボタンが押された
    if( isset($_POST['write'])) {
//var_dump($_SESSION['parent_no']);

        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
        $mail = htmlspecialchars($_POST["mail"], ENT_QUOTES, "UTF-8");
        $msg = htmlspecialchars($_POST["message"], ENT_QUOTES, "UTF-8");
        $parentId = htmlspecialchars($_SESSION["parent_no"] , ENT_QUOTES, "UTF-8");
        if ($name != "" && $msg != "") {
          $logic->writeMsgData($parentId,$name, $mail, $msg);
          $_SESSION['parent_no']  = 0;
        } else {
          $message = sprintf('名前とコメントは必須入力項目です！');
        }
    }

    //　削除ボタンが押された
    if( isset($_POST['del'])) {
      $button = key($_POST['del']);
      $no = $_POST['idno'][$button];
      $logic->deleteMsgData($no);
    }

   //　コメントボタンが押された
    if( isset($_POST['res'])) {
      $button = key($_POST['res']);
      $parentNo = $_POST['idno'][$button];
      $message = sprintf('No.%sへのコメントです', $parentNo);
      $_SESSION['parent_no'] = $parentNo;
    }

    $parents = $logic->getMsgData();


} catch(PDOException $e){
  exit($e->getMessage());
}


?>

<html>
<head>
  <script src="msgproc.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>メッセージテスト</title>
</head>
<body>
  <h1>メッセージテスト</h1>
  <p>*は必須入力です</p>
  <!-- データ入力フォーム -->
  <form method="POST" action="">

    名前*：
  <input type="text" name="name" size="30" value="" /><br />
  メールアドレス：
  <input type="text" name="mail" size="30" value="" /><br />
  メッセージ*：<br />
  <textarea name="message" cols="30" rows="5"></textarea><br />
  画像ファイル:
  <input type="file" name="pic">
  <br />
  <br />
  <input type="hidden" name="parentId" value="<?php echo $parentNo; ?>" />
  <input type="submit" name="write" value="登録" />
  <span class="message"><?php echo $message; ?></span>
  </form>


 <?php

//  echo '<form method="POST" action="" >';
  echo '<form method="POST" action="" onsubmit="return submitChk()">';
   $idx = 0;

// 取得したデータを一覧表示
  foreach($parents as $row) {
    echo "<hr>{$row["id"]}：";
    if (!empty($row["mail"])) {
        echo "<a href=\"mailto:" . $row["mail"] . "\">"
        . $row["name"] . "</a>";
    }
    else {
        echo $row["name"];
    }
    echo "(" . date("Y/m/d H:i", strtotime($row["created_at"])) . ")";
    echo "<p>" . nl2br($row["message"]) . "</p>";

/*
    foreach ($row['res'] as $comment) {
      echo '<div class = "comment">';
      echo sprintf ('<div class = "header">%s    %s'</div>'.$comment["name"]);
      echo sprintf ('<div class = "message">%s</div>, $comment['message']);
      echo '</div>';
    }
*/
    echo sprintf('<input type="hidden" name="idno['.$idx.']" value="%s"  />',$row["id"]);
    echo '<input type="submit" name="res['.$idx.']" value="コメントする" />';
    echo '<input type="submit" name="del['.$idx.']" value="削除" />';

    $idx++;
}

?>

</body>
</html>

