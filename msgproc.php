<?php
require_once 'dbope.php';
require_once 'msgproc.js';

//readfile("msgproc.js");


class MsgProc
{
  // データアクセスクラスインスタンス
  protected $dbdb;
  
  // コンストラクタ
  public function __construct()
  {
    $this->dbdb = new DBAccess();

  } // end construct
  
  // ★メッセージ取得
  public function getMsgData()
  {
    // 親情報取得
    $parents = $this->dbdb->getParents();
/*--------------------------------------------

    // コメント（返信）情報追加ができず・・・sql文はok?、格納の仕方がng?
    foreach ($parents as $index => $parent) {
      $res = $this->dbdb->getChildren($parent['id']);
//var_dump($res['parentId']);
      if ($res) {
        $parents[$index]['res'] = $res;
      }
    }
*/
 //---------------------------------------------   
//var_dump($parents);
    return $parents;

  } // end getMsgData

  // ★メッセージ書き込み
  public function writeMsgData($parentId,$name, $mail, $msg)
  {
      $stmt = $this->dbdb->writeData($parentId,$name,$mail,$msg);

  // エラーチェック
    $error = $stmt->errorInfo();
    if ($error[0] != "00000") {
        $message = "データの追加に失敗しました。{$error[2]}";
    }
  } // end writeMsgData

  // ★メッセージ削除
  public function deleteMsgData($no)
  {
     $stmt = $this->dbdb->deleteData($no);
  // エラーチェック
    $error = $stmt->errorInfo();
    if ($error[0] != "00000") {
        $message = "データの削除に失敗しました。{$error[2]}";
    }
  }

} // end class
?>

