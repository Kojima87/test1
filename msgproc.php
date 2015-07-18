<?php
require_once 'dbope.php';

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
    return $this->dbdb->getParents();
  } // end getMsgData

  public function getMsg1Data($no) {
    return $this->dbdb->get1Data($no);
  }

  public function getCommentData()
  {
    $parents = $this->dbdb->getParents();
    foreach ($parents as $index => $parent) {
      $children = $this->dbdb->getChildren($parent['id']);
      $comments[$index] = $children;
    }
    return $comments;
  }

  // ★メッセージ書き込み
  public function writeMsgData($parentId,$name, $mail, $msg)
  {
//var_dump($parentId);

    if ($parentId == 0) {
      return $this->dbdb->writeData($parentId,$name,$mail,$msg);
    } else {
      return $this->dbdb->writeCommentData($parentId,$name,$mail,$msg);
    }
  } // end writeMsgData

// *メッセージ更新
  public function updateMsgData($no,$parentId,$name, $mail, $msg) 
  {
      return $this->dbdb->updateData($no,$parentId,$name,$mail,$msg);
  }

  // ★メッセージ削除
  public function deleteMsgData($no)
  {
    $stmt = $this->dbdb->deleteData($no);
    if ($stmt) {
       $stmt = $this->dbdb->deleteCommData($no);
    }

     return $stmt;
  }

  public function searchMsgData($word) // コメント分も抽出しないと
  {
    return $this->dbdb->searchData($word);
  }
} // end class
?>

