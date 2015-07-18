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
        $msg = htmlspecialchars($_POST["msg"], ENT_QUOTES, "UTF-8");
        $parentId = htmlspecialchars($_SESSION["parent_no"] , ENT_QUOTES, "UTF-8");
        if ($name != "" && $msg != "") {
//var_dump($_SESSION['id']);
          if ($_SESSION['id'] == "") { // 変更処理
            $result = $logic->writeMsgData($parentId,$name, $mail, $msg);
          } else {
            // 現在のデータを表示させる？
            $result = $logic->updateMsgData($_SESSION['id'],$parentId,$name, $mail, $msg);
            $_SESSION['message']="";
          }
          if (!$result) {
            $error = $result->errorInfo();
            if ($error[0] != "00000") {
                $message = "データの追加に失敗しました。{$error[2]}";
            }
          }
          $_SESSION['parent_no']  = 0;
          $_SESSION['id']  = "";
          $_SESSION['name1'] = "";
          $_SESSION['mail1'] = "";
          $_SESSION['msg1'] = "";
        } else {
          $message = $_SESSION['message'] . sprintf("名前とコメントは必須入力項目です！");
        }
    }

    //　キャンセルボタンが押された
    if( isset($_POST['cancel'])) {
      $message = "";
      $_SESSION['message'] = "";
      $_SESSION['id'] = "";
      $_SESSION['parent_no'] = 0;
      $_SESSION['name1'] = "";
      $_SESSION['mail1'] = "";
      $_SESSION['msg1'] = "";
    }

   //　検索ボタンが押された　★作業中★
    if( isset($_POST['search'])) {
      $parents = $logic->searchMsgData($_POST['word']);
    }

    // 変更ボタンが押された
    if( isset($_POST['update'])) {
      $button = key($_POST['update']);
      $no = $_POST['idno'][$button];
      $message = sprintf('No.%sを変更します。', $no);
      $_SESSION['message'] = sprintf('No.%sを変更します。', $no);
      $_SESSION['id'] = $no;
      $get1data = $logic->getMsg1Data($no);
      if (!$get1data) {
        $error = $get1data->errorInfo();
        if ($error[0] != "00000") {
          $message = "データの取得に失敗しました。{$error[2]}";
        }
      } else {
        foreach ($get1data as $data) {
          $_SESSION['name1'] = $data["name"];
          $_SESSION['mail1'] = $data["mail"];
          $_SESSION['msg1'] = $data["msg"];
        }
      }
   }

    //　削除ボタンが押された
    if( isset($_POST['del'])) {
      $button = key($_POST['del']);
      $no = $_POST['idno'][$button];
      $result = $logic->deleteMsgData($no);
      if (!$result) {
        $error = $result->errorInfo();
        if ($error[0] != "00000") {
          $message = "データの削除に失敗しました。{$error[2]}";
        }
      }
      $_SESSION['name1'] = "";
      $_SESSION['mail1'] = "";
      $_SESSION['msg1'] = "";
   }

   //　コメントボタンが押された
    if( isset($_POST['res'])) {
      $button = key($_POST['res']);
      $parentNo = $_POST['idno'][$button];
      $message = sprintf('No.%sへのコメントです。', $parentNo);
      $_SESSION['message'] = sprintf('No.%sへのコメントです。', $parentNo);
      $_SESSION['parent_no'] = $parentNo;
      $_SESSION['name1'] = "";
      $_SESSION['mail1'] = "";
      $_SESSION['msg1'] = "";
    }

// parentsにデータが入っていたら、検索モードなので、以下はスキップする
//var_dump($parents);
    if (!$parents) {
      $parents = $logic->getMsgData();
      $children = $logic->getCommentData();
    }
} catch(PDOException $e){
  exit($e->getMessage());
}


?>

<html>
<head>
<!--  <script src="msgproc.js"></script> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>メッセージテスト</title>
  <style>
  .message { color: red; }
  </style>
</head>
<body>
  <script src="msgproc.js"></script>
  <h1>メッセージテスト</h1>
  <p>*は必須入力です</p>
  <!-- データ入力フォーム -->
  <form method="POST" action="">
  <table border = "1">
    <tr>
      <td>名前*
      <td><input type="text" name="name" size="30" value="<?php echo $_SESSION['name1']; ?>" /><br />
    </tr>
    <tr>
      <td>メールアドレス
      <td><input type="text" name="mail" size="30" value="<?php echo $_SESSION['mail1']; ?>" /><br />
    </tr>
    <tr>
      <td>メッセージ*</td>
      <td><textarea name="msg" cols="30" rows="5" ><?php echo $_SESSION['msg1']; ?></textarea><br />
    </tr>
    <tr>
      <td>画像ファイル
      <td><input type="file" name="pic">
    </tr>
  </table>
  検索文字列：
  <input type="text" name="word" size="30" value="" />
  <input type="submit" name="search" value="検索" /><br />
  <br />
  <input type="hidden" name="parentId" value="<?php echo $parentNo; ?>" />
  <input type="submit" name="write" value="登録" />
  <input type="submit" name="cancel" value="キャンセル" />
  <span class="message"><?php echo $message; ?></span>

  </form>


 <?php

  echo '<form method="POST" action="" >';
//  echo '<form method="POST" action="" onsubmit="return submitChk()">';
   $idx = 0;

// 取得したデータを一覧表示
  foreach($parents as $row) {
    echo "<hr>{$row["id"]}：";
    $parent_no = $row["id"];
    if (!empty($row["mail"])) {
        echo "<a href=\"mailto:" . $row["mail"] . "\">" . $row["name"] . "</a>";
    }
    else {
        echo $row["name"];
    }
    echo "(" . date("Y/m/d H:i", strtotime($row["created_at"])) . ")";
    echo "<p>" . nl2br($row["msg"]) . "</p>";

    foreach ($children[$idx] as $child) {
        echo "<li>" . $child[2] . ":" . $child[4] . "</li>";
    }
    echo "<br>";
    
    echo sprintf('<input type="hidden" name="idno['.$idx.']" value="%s"  />',$row["id"]);
    echo '<input type="submit" name="res['.$idx.']" value="コメントする" />';
    echo '<input type="submit" name="update['.$idx.']" value="変更"  onClick="return submitEdit()" />';
    echo '<input type="submit" name="del['.$idx.']" value="削除" onClick="return submitDel()" />';

    $idx++;
}

?>

</body>
</html>

